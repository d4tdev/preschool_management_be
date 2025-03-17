<?php

namespace App\Repositories\Criteria;

use App\Models\BaseMasterModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractSortAndFilterCriteria {
    /**
     * @var array
     */
    protected $filters;

    /**
     * @var array
     */
    protected $sorts;

    /**
     * @var array
     */
    protected $searchConditions;

    public function __construct(array $filters = [], array $sorts = [], array $search = [])
    {
        $this->filters = $filters;
        $this->sorts = $sorts;
        $this->searchConditions = $search;
    }

    /**
     * @param Builder|Model $builder
     * @return Builder|Model
     */
    abstract public function sort($builder);

    /**
     * @param Builder|Model $builder
     * @return Builder|Model
     */
    abstract public function filter($builder);

    /**
     * @param Builder|Model $builder
     * @return Builder|Model
     */
    abstract public function search($builder);
}
