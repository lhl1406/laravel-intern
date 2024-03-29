<?php

// app\Repositories\BaseRepositoryEloquent.php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepositoryEloquent implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    // Các phương thức khác...
}
