<?php
namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

interface EloquentRepositoryInterface {
    public function create($attributes): Model;
    public function update($id, $attributes): Model;
    public function destroy($id): bool;
    public function find($id): Model;
    public function where(...$where): Builder;
    public function with(...$with): Builder;
    public function get(): Collection;
}
