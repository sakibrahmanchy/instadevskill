<?php

namespace App\Repository\Repositories;

use App\Models\Follow;
use App\Repository\Interfaces\FollowRepositoryInterface;

class FollowRepository extends BaseRepository implements FollowRepositoryInterface {
    protected $model;
    public function __construct(Follow $model)
    {
        $this->model = $model;
    }
}
