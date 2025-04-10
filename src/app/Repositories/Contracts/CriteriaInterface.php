<?php

namespace App\Repositories\Contracts;

interface CriteriaInterface {
    public function apply($model, RepositoryInterface $repository);
}
