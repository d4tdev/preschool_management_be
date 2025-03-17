<?php

namespace App\Repositories\Criteria\Fee;

use App\Repositories\Contracts\CriteriaInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Criteria\AbstractSortAndFilterCriteria;
use App\Traits\SortAndFilterCriteria;

class SortAndFilterFeeCriteria extends AbstractSortAndFilterCriteria implements CriteriaInterface
{
    use SortAndFilterCriteria;

    public function __construct(array $filters = [], array $sorts = [], array $search = [])
    {
        parent::__construct($filters, $sorts, $search);
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $this->filter($model);
        $model = $this->sort($model);
        $model = $this->search($model);

        $select = [
            '*',
        ];

        return $model->select($select);
    }

    public function sort($builder)
    {
        $builder->orderBy('created_at', 'desc');
        return $builder;
    }

    public function filter($builder)
    {
        if (!empty($this->filters['parent_id'])) {
            $builder = $builder->whereHas('student', function ($query) {
                $query->where('parent_id', $this->filters['parent_id']);
            });
        }

        if (!empty($this->filters['class_id'])) {
            $builder = $builder->whereHas('student', function ($query) {
                $query->where('class_id', $this->filters['class_id']);
            });
        }

        if (!empty($this->filters['parent_id'])) {
            $builder = $builder->whereHas('student', function ($query) {
                $query->where('parent_id', $this->filters['parent_id']);
            });
        }
        return $builder;
    }

    public function search($builder)
    {
        return $builder;
    }
}
