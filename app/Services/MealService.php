<?php

namespace App\Services;

use App\Models\Meal;
use App\Repositories\Criteria\Meal\SortAndFilterMealCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;

class MealService extends AbstractService {
    protected Repository $mealRepo;
    public function __construct(Meal $meal)
    {
        $this->mealRepo = new Repository($meal);
    }

    public function getList($filters, $sorts, $search, $limit)
    {
        return $this->mealRepo->pushCriteria(
            new SortAndFilterMealCriteria($filters, $sorts, $search)
        )->all();
    }

    public function getDetail($id)
    {
        return $this->mealRepo->with(['createdBy', 'updatedBy'])->find($id);
    }

    public function create($data)
    {
        return $this->mealRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->mealRepo->update($id, $data);
    }

    public function delete($id)
    {
        $meal = $this->mealRepo->find($id);
        return $meal->delete();
    }
}
