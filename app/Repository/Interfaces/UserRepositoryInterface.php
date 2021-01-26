<?php
namespace App\Repository\Interfaces;

use Illuminate\Support\Collection;

interface UserRepositoryInterface extends EloquentRepositoryInterface {
    public function all(): Collection;
}
