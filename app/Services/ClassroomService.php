<?php

namespace App\Services;

use App\Models\Classroom;
use App\Repositories\Criteria\Classroom\SortAndFilterClassroomCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;

class ClassroomService extends AbstractService {
    protected Repository $classroomRepo;
    public function __construct(Classroom $classroom)
    {
        $this->classroomRepo = new Repository($classroom);
    }

    public function getList($filters, $sorts, $search, $limit)
    {
        return $this->classroomRepo->pushCriteria(
            new SortAndFilterClassroomCriteria($filters, $sorts, $search)
        )->all();
    }

    public function getDetail($id)
    {
        return $this->classroomRepo->with(['createdBy', 'updatedBy'])->find($id);
    }

    public function create($data)
    {
        return $this->classroomRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->classroomRepo->update($id, $data);
    }

    public function delete($id)
    {
        $classroom = $this->classroomRepo->find($id);
        return $classroom->delete();
    }
}
