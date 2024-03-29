<?php

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Support\Facades\Log;

class GroupRepository extends BaseRepository
{
    public function getModel()
    {
        return Group::class;
    }

    public function getAll()
    {
        try {
            $groupList = $this->model->orderBy('name')
                ->whereNull('deleted_date')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return [];
        }

        return $groupList;
    }

    public function getGroupList($limit = 10)
    {
        try {
            $groupList = $this->model->orderBy('id', 'desc')
                ->paginate($limit);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return [];
        }

        return $groupList;
    }
}
