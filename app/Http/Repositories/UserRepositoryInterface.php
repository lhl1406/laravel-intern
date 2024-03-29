<?php

namespace App\Repositories;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getByEmail($email);
    // Các phương thức khác đặc biệt cho người dùng...
}
