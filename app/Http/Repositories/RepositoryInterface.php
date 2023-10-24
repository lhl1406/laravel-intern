<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all();
    public function find($id);
    // Các phương thức khác...
}