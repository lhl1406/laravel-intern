<?php

namespace App\Repositories;

use App\Models\User;

class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    // Các phương thức khác đặc biệt cho người dùng...
}
