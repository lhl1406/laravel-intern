<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEditUserRequest;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\UserRequest;
use App\Libs\ConfigUtil;
use App\Libs\CSVUtil;
use App\Libs\ValueUtil;
use App\Models\User;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class userController extends Controller
{
    private $userRepository;

    private $groupRepository;

    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository)
    {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Render screen A-01-LOG_Login
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function login()
    {

        $pageTitle = 'Login';

        return view('partials.form.login', compact('pageTitle'));
    }

    /**
     * Handle check account exists or not
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return mixed redirect dashboard | back
     */
    public function checkLogin(UserRequest $request)
    {
        $userDupplicateEmail = $this->userRepository->dupllicateEmailForLogin($request->email);

        if ($userDupplicateEmail->count() > 1) {
            return back()->withErrors([
                'errorMessage' => ConfigUtil::getMessage('EBT016'),
            ]);
        }

        if (Auth::attempt([...$request->only(['email', 'password']), 'deleted_date' => null])) {
            $ridirecTo = 'admin/dashboard';

            if ($request->session()->get('previous_url')) {
                $ridirecTo = $request->session()->get('previous_url');
                $request->session()->forget('previous_url');
            }

            return redirect()->intended($ridirecTo);
        }

        return back()->withErrors([
            'errorMessage' => ConfigUtil::getMessage('EBT016'),
        ]);
    }

    /**
     * Remove the authentication information from the user's session
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return redirect login
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Render screen A-01-Use
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(SearchUserRequest $request)
    {
        $conditionSearch = $request->session()->get('conditionSearch') ?? [];
        $newConditionSearch = $request->only(['name', 'started_date_from', 'started_date_to']);

        if (count($newConditionSearch) > 0 && ! $request->session()->has('isSearch')) {
            $request->session()->put('isSearch', true);
        }

        if (empty($request->all()) && ! empty($conditionSearch)) {
            $newConditionSearch = array_merge($newConditionSearch, $conditionSearch);
        }

        $userList = $this->userRepository->getByConditionSearch($newConditionSearch);

        $userList = $userList->onEachSide($userList->lastPage());

        $pageTitle = 'User List';

        $request->session()->put('conditionSearch', $newConditionSearch);

        return view('admin.user-list.index', compact('userList', 'pageTitle'));
    }

    /**
     * Clear session condition search and flag search
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return redirect A-01-Use
     */
    public function clear(Request $request)
    {
        $request->session()->forget('conditionSearch');
        $request->session()->forget('isSearch');

        return true;
    }

    /**
     * Export csv file user list
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCSVFile(Request $request)
    {

        $fileName = 'list_user_'.Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis').'.csv';
        $header = [
            'ID',
            'User Name',
            'Email',
            'Group ID',
            'Group Name',
            'Started Date',
            'Position',
            'Created Date',
            'Updated Date',
        ];
        $headerRespone = [
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Content-Type' => 'text/csv',
        ];
        $conditionSearch = $request->session()->get('conditionSearch');
        $userList = $this->userRepository->getByConditionSearch($conditionSearch, null);

        if (count($userList) == 0) {
            return redirect()->route('admin.user.index');
        }

        $userListToExport = collect($userList)->map(function ($user) {
            return [
                'ID' => $user->id,
                'User Name' => $user->name,
                'Email' => $user->email,
                'Group ID' => $user->group_id ?? '',
                'Group Name' => $user->group->name ?? '',
                'Started Date' => formatDateTime($user->started_date),
                'Position' => getUserFlagLabel($user->position_id),
                'Created Date' => formatDateTime($user->created_date),
                'Updated Date' => formatDateTime($user->updated_date),
            ];
        });

        $result = CSVUtil::exportCSVFile($userListToExport, $header);

        if ($result) {
            return response($result, 200, $headerRespone);
        }
    }

    /**
     * Render screen A-02-USE for edit
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request)
    {
        $user = $this->userRepository->getById($request->id, true);
        $pageTitle = 'Edit';
        $groupList = $this->groupRepository->getAll();

        if (! $user) {
            return abort(404);
        }

        $positionList = [
            [
                'id' => ValueUtil::constToValue('user.user_flg.DIRECTOR'),
                'name' => getUserFlagLabel(ValueUtil::constToValue('user.user_flg.DIRECTOR')),
            ],
            [
                'id' => ValueUtil::constToValue('user.user_flg.DEPARTMENT_LEADER'),
                'name' => getUserFlagLabel(ValueUtil::constToValue('user.user_flg.DEPARTMENT_LEADER')),
            ],
            [
                'id' => ValueUtil::constToValue('user.user_flg.TEAM_LEADER'),
                'name' => getUserFlagLabel(ValueUtil::constToValue('user.user_flg.TEAM_LEADER')),
            ],
            [
                'id' => ValueUtil::constToValue('user.user_flg.TEAM_MEMBER'),
                'name' => getUserFlagLabel(ValueUtil::constToValue('user.user_flg.TEAM_MEMBER')),
            ],
        ];

        return view('admin.user-list.add-edit-delete', compact('user', 'pageTitle', 'groupList', 'positionList'));
    }

    /**
     * Save data user to database
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return redirect A-01-USE
     */
    public function update(AddEditUserRequest $request)
    {
        if (isset($request->id)) {
            $user = $this->userRepository->getById($request->id);
            $startedDate = DateTime::createFromFormat('d/m/Y', $request->started_date)->format('Y-m-d');
            if ($user) {
                if (isset($request->password)) {
                    $password = Hash::make($request->password);
                    $data = collect($request->only(['name', 'email', 'group_id', 'position_id']))
                        ->merge([
                            'password' => $password,
                            'id' => $request->id,
                            'started_date' => $startedDate,
                            'updated_date' => Carbon::now(),
                        ])
                        ->toArray();

                    $result = $this->userRepository->save($user, $data);
                } else {
                    $data = collect($request->only(['name', 'email', 'group_id', 'position_id']))
                        ->merge([
                            'started_date' => $startedDate,
                            'updated_date' => Carbon::now(),
                        ])
                        ->toArray();

                    $result = $this->userRepository->save($user, $data);
                }
            }
        }

        if ($result) {
            return redirect()->route('admin.user.index')
                ->with('success', true)
                ->with('message', ConfigUtil::getMessage('EBT096'));
        }

        return redirect()->route('admin.user.index')
            ->with('success', false)
            ->with('message', ConfigUtil::getMessage('EBT093'));
    }

    /**
     * Change password user to database
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return redirect A-01-USE
     */
    public function updatePassword(Request $request)
    {
        $result = true;

        if (isset($request->id)) {
            $user = $this->userRepository->getById($request->id);

            if ($user) {
                if (isset($request->password)) {
                    $password = Hash::make($request->password);
                    $data = [
                        'password' => $password,
                        'id' => $request->id,
                        'updated_date' => Carbon::now(),
                    ];

                    $result = $this->userRepository->save($user, $data);
                }
            }
        }

        if ($result) {
            return redirect()->route('admin.user.index')
                ->with('success', true)
                ->with('message', ConfigUtil::getMessage('EBT096'));
        }

        return redirect()->route('admin.user.index')
            ->with('success', false)
            ->with('message', ConfigUtil::getMessage('EBT093'));
    }

    /**
     * Render screen A-02-USE for add
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function add(Request $request)
    {
        $checkForAdd = true;
        $pageTitle = 'Add';
        $groupList = $this->groupRepository->getAll();
        $positionList = [
            [
                'id' => ValueUtil::constToValue('user.user_flg.DIRECTOR'),
                'name' => getUserFlagLabel(ValueUtil::constToValue('user.user_flg.DIRECTOR')),
            ],
            [
                'id' => ValueUtil::constToValue('user.user_flg.DEPARTMENT_LEADER'),
                'name' => getUserFlagLabel(ValueUtil::constToValue('user.user_flg.DEPARTMENT_LEADER')),
            ],
            [
                'id' => ValueUtil::constToValue('user.user_flg.TEAM_LEADER'),
                'name' => getUserFlagLabel(ValueUtil::constToValue('user.user_flg.TEAM_LEADER')),
            ],
            [
                'id' => ValueUtil::constToValue('user.user_flg.TEAM_MEMBER'),
                'name' => getUserFlagLabel(ValueUtil::constToValue('user.user_flg.TEAM_MEMBER')),
            ],
        ];

        return view('admin.user-list.add-edit-delete', compact('checkForAdd', 'pageTitle', 'groupList', 'positionList'));
    }

    /**
     * Create new user save to database
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return redirect A-01-USE
     */
    public function store(AddEditUserRequest $request)
    {
        $user = new User();
        $password = Hash::make($request->password);
        $startedDate = DateTime::createFromFormat('d/m/Y', $request->started_date)->format('Y-m-d');
        $data = collect($request->only(['name', 'email', 'group_id', 'position_id']))
            ->merge([
                'password' => $password,
                'id' => $request->id,
                'started_date' => $startedDate,
                'created_date' => Carbon::now(),
                'updated_date' => Carbon::now(),
            ])
            ->toArray();

        $result = $this->userRepository->save($user, $data);

        if ($result) {
            return redirect()->route('admin.user.index')
                ->with('success', true)
                ->with('message', ConfigUtil::getMessage('EBT096'));
        }

        return redirect()->route('admin.user.index')
            ->with('success', false)
            ->with('message', ConfigUtil::getMessage('EBT093'));
    }

    /**
     * Update deleted_date of user into database
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return redirect A-01-USE
     */
    public function delete(Request $request)
    {
        if (isset($request->id)) {
            if ($request->id == Auth::id()) {
                return redirect()->route('admin.user.index')
                    ->with('success', false)
                    ->with('message', ConfigUtil::getMessage('EBT086'));
            }

            $user = $this->userRepository->getById($request->id);

            if ($user) {
                $result = $this->userRepository->delete($user);

                if ($result) {
                    return redirect()->route('admin.user.index')
                        ->with('success', true)
                        ->with('message', ConfigUtil::getMessage('EBT096'));
                }
            }
        }

        return redirect()->route('admin.user.index')
            ->with('success', false)
            ->with('message', ConfigUtil::getMessage('EBT093'));
    }

    /**
     * Check exists email in database <> user login
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return bool true|false
     */
    public function checkExistsEmail(Request $request)
    {
        if (isset($request->id)) {
            $user = $this->userRepository->getByEmail($request->email, $request->id);
        } else {
            $user = $this->userRepository->getByEmail($request->email);
        }

        if ($user->count()) {
            return Response::json(true);
        }

        return Response::json(false);
    }

    /**
     * Check duplicate email in database
     *
     * @param  App\Http\Requests\SearchUserRequest  $request
     * @return bool true|false
     */
    public function checkDuplicateEmail(Request $request)
    {
        $users = $this->userRepository->getByEmail($request->email);

        if ($users->count() >= 2) {
            return Response::json(true);
        }

        return Response::json(false);
    }
}
