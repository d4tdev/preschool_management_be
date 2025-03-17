<?php

namespace App\Services;

use App\Models\Student;
use App\Repositories\Criteria\Student\SortAndFilterStudentCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;

class StudentService extends AbstractService {
    protected Repository $studentRepo;
    public function __construct(Student $student)
    {
        $this->studentRepo = new Repository($student);
    }

    public function getList($filters, $sorts, $search, $limit)
    {
        return $this->studentRepo->pushCriteria(
            new SortAndFilterStudentCriteria($filters, $sorts, $search)
        )->all();
    }

    public function getDetail($id)
    {
        return $this->studentRepo->with(['createdBy', 'updatedBy'])->find($id);
    }

    public function create($data)
    {
        return $this->studentRepo->create($data);
    }

    public function update($id, $data)
    {
        $status = $this->studentRepo->update($id, $data);
        return [
            'message' => $status
        ];
    }

    public function delete($id)
    {
        $student = $this->studentRepo->find($id);
        return $student->delete();
    }
}
