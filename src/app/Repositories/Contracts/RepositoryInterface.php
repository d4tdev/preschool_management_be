<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface {
    public function all(array $columns = ['*']);
    public function paginate(int $limit, array $columns = ['*']);
    public function first(array $columns = ['*']);
    public function create(array $data);
    public function updateOrCreate($attributes, $values);
    public function update(int $id, array $data);
    public function delete();
    public function count();
    public function with(array $relations);
    public function withCount(array $relations);
    public function find(int $id, array $columns = ['*']);
    public function findWhere(array $where);
    public function findWhereIn(string $field, array $values);
    public function findWhereNotIn(string $field, array $values);
    public function has(string $relationship, string $operator, int $count);
    public function orderBy(string $column, string $direction = 'asc');
    public function applyCriteria();
    public function pushCriteria(CriteriaInterface $criteria);
    public function getByCriteria(CriteriaInterface $criteria);
    public function resetCriteria();
    public function firstOrCreate(array $attributes, array $data);
}
