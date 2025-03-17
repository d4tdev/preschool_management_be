<?php

namespace App\Services;

use App\Mail\FeeMail;
use App\Models\Fee;
use App\Models\Student;
use App\Repositories\Criteria\Fee\SortAndFilterFeeCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Mail;

class FeeService extends AbstractService {
    protected Repository $feeRepo;
    public function __construct(Fee $fee)
    {
        $this->feeRepo = new Repository($fee);
    }

    public function getList($filters, $sorts, $search, $limit)
    {
        return $this->feeRepo->pushCriteria(
            new SortAndFilterFeeCriteria($filters, $sorts, $search)
        )->all();
    }

    public function getDetail($id)
    {
        return $this->feeRepo->with(['createdBy', 'updatedBy'])->find($id);
    }

    public function create($data)
    {
        foreach ($data['students'] as $student) {
            $dataCreated = $this->feeRepo->create(
                array_merge(
                    $data,
                    ['student_id' => $student['id']]
                )
            );
            $student = Student::where('id', $student['id'])->with('parent')->first();
            Mail::to($student->parent->email)->queue(new FeeMail(array_merge($data, ['student' => $student, 'fee' => $dataCreated])));
        }
        return [
            'message' => 1
        ];
    }

    public function update($id, $data)
    {
        return $this->feeRepo->update($id, $data);
    }

    public function delete($id)
    {
        $fee = $this->feeRepo->find($id);
        return $fee->delete();
    }
}
