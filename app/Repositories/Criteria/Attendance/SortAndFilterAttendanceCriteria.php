<?php

namespace App\Repositories\Criteria\Attendance;

use App\Repositories\Contracts\CriteriaInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Criteria\AbstractSortAndFilterCriteria;
use App\Traits\SortAndFilterCriteria;
use Carbon\Carbon;

class SortAndFilterAttendanceCriteria extends AbstractSortAndFilterCriteria implements CriteriaInterface
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
        if (!empty($this->filters['student_id'])) {
            $builder = $builder->where('student_id', $this->filters['student_id']);
        }

        if (!empty($this->filters['class_id'])) {
            $builder = $builder->whereHas(
                'student',
                function ($query) {
                    $query->where('class_id', $this->filters['class_id']);
                }
            );
        }

        if (!empty($this->filters['date'])) {
            $builder = $builder->where('date', $this->filters['date']);
        }

        if (!empty($this->filters['month'])) {
            $startDate = Carbon::createFromFormat(
                'Y-m-d',
                Carbon::now()->format('Y') .'-'.$this->filters['month'] . '-01'
            );
            $endDate = Carbon::createFromFormat(
                'Y-m-d',
                Carbon::now()->format('Y') .'-'.$this->filters['month'] . '-01'
            )->endOfMonth();
            $builder = $builder->whereBetween('date', [$startDate, $endDate]);
        }
        return $builder;
    }

    public function search($builder)
    {
        return $builder;
    }
}
