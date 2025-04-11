<?php

namespace App\Services;

use App\Models\Classroom;
use App\Models\User;
use App\Repositories\Criteria\Classroom\SortAndFilterClassroomCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;

class ClassroomService extends AbstractService
{
    protected Repository $classroomRepo;
    protected Repository $userRepo;

    public function __construct(Classroom $classroom, User $user)
    {
        $this->classroomRepo = new Repository($classroom);
        $this->userRepo = new Repository($user);
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

        $data = $this->classroomRepo->create($data);
        $this->userRepo->update($data['teacher_id'], [
            'class_id' => $data->id
        ]);
        return $data;
    }

    public function update($id, $data)
    {
        $this->userRepo->update($data['teacher_id'], [
            'class_id' => $id
        ]);
        return $this->classroomRepo->update($id, $data);
    }

    public function delete($id)
    {
        $classroom = $this->classroomRepo->find($id);
        return $classroom->delete();
    }
}
