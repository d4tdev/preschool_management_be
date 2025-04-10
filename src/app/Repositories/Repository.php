<?php

namespace App\Repositories;

use App\Repositories\Contracts\CriteriaInterface;
use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Repository implements RepositoryInterface {
    protected $model;
    protected $criteria;
    protected $skipCriteria;

    protected function resetModel(): void
    {
        $this->model = $this->model->getModel();
    }
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->criteria = new Collection();
    }

    public function getInstance()
    {
        return $this->model;
    }

    public function all(array $columns = ['*'])
    {
        $this->applyCriteria();
        $model = $this->model->get($columns);
        $this->resetModel();
        return $model;
    }

    public function paginate(int $limit, array $columns = ['*'])
    {
        $this->applyCriteria();
        $model = $this->model->paginate($limit, $columns);
        $this->resetModel();
        return $model;
    }

    public function first(array $columns = ['*'])
    {
        $this->applyCriteria();
        $model = $this->model->first($columns);
        $this->resetModel();
        return $model;
    }

    public function create(array $data)
    {
        $this->resetModel();
        return $this->model->create($data);
    }

    public function updateOrCreate($attributes, $values)
    {
        $this->resetModel();
        return $this->model->updateOrCreate($attributes, $values);
    }

    public function update(int $id, array $data)
    {
        return $this->model->where($this->model->getPrimaryKey(), '=', $id)->update($data);
    }

    public function delete()
    {
        $status = $this->model->delete();
        $this->resetModel();
        return $status;
    }

    public function count()
    {
        $this->applyCriteria();
        return $this->model->count();
    }

    public function with(array $relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function withCount(array $relations)
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }

    public function find(int $id, array $columns = ['*'])
    {
        $this->applyCriteria();
        $model = $this->model->find($id, $columns);
        $this->resetModel();
        return $model;
    }

    public function findWhere(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                [$field, $condition, $val] = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
        return $this;
    }

    public function findWhereIn(string $field, array $values)
    {
        $this->model = $this->model->whereIn($field, $values);
        return $this;
    }

    public function findWhereNotIn(string $field, array $values)
    {
        $this->model = $this->model->whereNotIn($field, $values);
        return $this;
    }

    public function has(string $relationship, string $operator, int $count)
    {
        $this->model = $this->model->has($relationship, $operator, $count);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    public function getCriteria()
    {
        return $this->criteria;
    }
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        $criteria = $this->getCriteria();

        if ($criteria) {
            foreach ($criteria as $c) {
                if ($c instanceof CriteriaInterface) {
                    $this->model = $c->apply($this->model, $this);
                }
            }
        }
        return $this;
    }

    public function pushCriteria(CriteriaInterface $criteria)
    {
        $this->criteria->push($criteria);
        return $this;
    }

    public function getByCriteria(CriteriaInterface $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);
        $results = $this->model->get();
        $this->resetModel();
        return $results;
    }

    public function resetCriteria()
    {
        $this->criteria = new Collection();
        $this->resetModel();
        return $this;
    }
    public function firstOrCreate(array $attributes, array $data)
    {
        $this->resetModel();
        return $this->model->firstOrCreate($attributes, $data);
    }
}
