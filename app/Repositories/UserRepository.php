<?php

namespace App\Repositories;

use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }

    /**
     * Get user list by condition search
     *
     * @param  array  $conditionSearch
     * @param $limit default 10
     * @return @mixed $result
     */
    public function getByConditionSearch($conditionSearch, $limit = 10)
    {
        $result = $this->model;

        if (isset($conditionSearch['started_date_from'])) {
            $dateTo = DateTime::createFromFormat('d/m/Y', $conditionSearch['started_date_from']);
            $result = $result->where('started_date', '>=', $dateTo->format('Y-m-d'));
        }

        if (isset($conditionSearch['started_date_to'])) {
            $dateTo = DateTime::createFromFormat('d/m/Y', $conditionSearch['started_date_to']);
            $result = $result->where('started_date', '<=', $dateTo->format('Y-m-d'));
        }

        if (isset($conditionSearch['name'])) {
            $result = $result->where('name', 'LIKE', '%'.$conditionSearch['name'].'%');
        }

        // Sort by name if same name sort by started date if same then sort by id
        $result = $result->orderBy('name')
            ->orderBy('started_date')
            ->orderBy('id');

        if (empty($limit)) {
            return $result->whereNull('deleted_date')->get();
        }

        return $result->whereNull('deleted_date')->paginate($limit);
    }

    /**
     * Get user list by email
     *
     * @param string email
     * @param @mixed id
     * @return @mixed $result
     */
    public function getByEmail(string $email, $id = null)
    {
        if (isset($id)) {
            $result = $this->model->where('email', $email)
                ->where('id', '!=', $id)
                ->get();
        } else {
            $result = $this->model->where('email', $email)
                ->get();
        }

        if ($result) {
            return $result;
        }

        return [];
    }

    /**
     * Get user list by email
     *
     * @param string email
     * @param @mixed id
     * @return @mixed $result
     */
    public function dupllicateEmailForLogin(string $email)
    {
        try {
            $result = $this->model->where('email', $email)
                ->whereNull('deleted_date')
                ->get();
        } catch (Exception $exption) {
            Log::error($exption->getMessage());
        }

        if ($result) {
            return $result;
        }

        return [];
    }
}
