<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportCSVRequest;
use App\Libs\ConfigUtil;
use App\Libs\CSVUtil;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;

class GroupController extends Controller
{
    private $userRepository;

    private $groupRepository;

    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository)
    {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Render screen A-01-GRO
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $groupList = $this->groupRepository->getGroupList();
        $pageTitle = 'Group List';
        $groupList = $groupList->onEachSide($groupList->lastPage());

        foreach ($groupList as $group) {
            $group->user_leader = $this->userRepository->getById($group->group_leader_id);
        }

        return view('admin.group-list.index', compact('groupList', 'pageTitle'));
    }

    public function import(ImportCSVRequest $request)
    {
        $file = $request->file('file');
        $csvFile = fopen($file->getPathname(), 'r');

        if (CSVUtil::checkForEmptyEndLine($file->getPathname())) {
            $row = count(file($file->getPathname())) + 1;

            return redirect()->route('admin.group.index')
                ->with('success', false)
                ->with('message', "Dòng $row : ".ConfigUtil::getMessage('EBT095'));
        }

        $headersOfFile = fgetcsv($csvFile);
        $errorMessages = [];
        $headerCombine = [
            'id' => 'ID',
            'name' => 'Group Name',
            'note' => 'Group Note',
            'group_leader_id' => 'Group Leader',
            'group_floor_number' => 'Floor Number',
            'isDelete' => 'Delete',
        ];

        $result = CSVUtil::readCSVFile($csvFile, $headersOfFile);

        if (empty($result) || $headersOfFile[0] == null) {
            return redirect()->route('admin.group.index')
                ->with('success', false)
                ->with('message', ConfigUtil::getMessage('EBT036', ['CSV Data']));
        }

        if (! empty($result) && isset($result['error'])) {
            return redirect()->route('admin.group.index')
                ->with('success', false)
                ->with('message', $result['error']);
        }

        $errorMessages = CSVUtil::checkFormatHeader($headersOfFile, array_values($headerCombine));

        if (! empty($errorMessages)) {
            return redirect()->route('admin.group.index')
                ->with('success', false)
                ->with('message', $errorMessages);
        }

        fclose($csvFile);

        $errorMessages = CSVUtil::checkContentFile($result);

        if (! empty($errorMessages)) {
            return redirect()->route('admin.group.index')
                ->with('success', false)
                ->with('message', $errorMessages);
        }

        $data = [];

        foreach ($result as $index => $group) {
            $lineData = [];
            foreach ($headerCombine as $key => $value) {
                $lineData[$key] = $group[$value];
            }

            $data[] = $lineData;
        }

        $result = $this->groupRepository->saveMany($data);

        if (! $result) {
            return redirect()->route('admin.group.index')
                ->with('success', false)
                ->with('message', ConfigUtil::getMessage('EBT090'));
        }

        return redirect()->route('admin.group.index')
            ->with('success', true)
            ->with('message', ConfigUtil::getMessage('EBT092'));
    }
}
