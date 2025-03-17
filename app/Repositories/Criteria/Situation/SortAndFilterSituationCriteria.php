<?php

namespace App\Repositories\Criteria\Situation;

use App\Repositories\Contracts\CriteriaInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Criteria\AbstractSortAndFilterCriteria;
use App\Traits\SortAndFilterCriteria;
use Carbon\Carbon;

class SortAndFilterSituationCriteria extends AbstractSortAndFilterCriteria implements CriteriaInterface
{
    use SortAndFilterCriteria;

    protected $startDate;
    protected $endDate;

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
        $builder = $builder->orderBy('id', 'desc');
        return $builder;
    }

    public function filter($builder)
    {
        if (!empty($this->filters['parent_id'])) {
            $builder = $builder->whereHas('student', function ($query) {
                $query->where('parent_id', $this->filters['parent_id']);
            });
        }
        if (!empty($this->filters['month'])) {
            $this->startDate = Carbon::createFromFormat(
                'Y-m-d', Carbon::now()->format('Y') . '-' . $this->filters['month'] . '-01'
            )->startOfMonth();
            $this->endDate = Carbon::createFromFormat(
                'Y-m-d', Carbon::now()->format('Y') . '-' . $this->filters['month'] . '-01'
            )->endOfMonth();
            $builder = $builder->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }
        return $builder;
    }

    public function search($builder)
    {
        return $builder;
    }
}
