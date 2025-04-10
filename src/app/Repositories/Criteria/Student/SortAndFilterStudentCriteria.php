<?php

namespace App\Repositories\Criteria\Student;

use App\Repositories\Contracts\CriteriaInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Criteria\AbstractSortAndFilterCriteria;
use App\Traits\SortAndFilterCriteria;

class SortAndFilterStudentCriteria extends AbstractSortAndFilterCriteria implements CriteriaInterface
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
        return $builder;
    }

    public function filter($builder)
    {
        if (isset($this->filters['class_id'])) {
            $builder = $builder->where('class_id', $this->filters['class_id']);
        }
        return $builder;
    }

    public function search($builder)
    {
        return $builder;
    }
}
