<?php

namespace App\Repository\Repositories;

use App\Repository\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

class BaseRepository implements EloquentRepositoryInterface {
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes): Model
    {
        return $this->model->where(['id' => $id])->update($attributes);
    }

    public function destroy($id): bool
    {
        return $this->model->destroy($id);
    }

    public function find($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function where(...$where): Builder
    {
        return $this->model->where(...$where);
    }

    public function with(...$with): Builder
    {
        return $this->model->with(...$with);
    }

    public function get(): Collection
    {
        return $this->model->get();
    }
}
