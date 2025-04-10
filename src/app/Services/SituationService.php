<?php

namespace App\Services;

use App\Http\Resources\SubjectResource;
use App\Jobs\SendSituationEmail;
use App\Mail\SituationMail;
use App\Models\Situation;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use App\Repositories\Criteria\Situation\SortAndFilterSituationCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Mail;

class SituationService extends AbstractService
{
    protected Repository $situationRepo;

    public function __construct(Situation $situation)
    {
        $this->situationRepo = new Repository($situation);
    }

    public function getList($filters, $sorts, $search, $limit)
    {
        return $this->situationRepo->pushCriteria(
            new SortAndFilterSituationCriteria($filters, $sorts, $search)
        )->all();
    }

    public function getDetail($id)
    {
        return $this->situationRepo->with(['createdBy', 'updatedBy'])->find($id);
    }

    public function create($data)
    {

        foreach ($data['students'] as $student) {
            $dataCreated = $this->situationRepo->create(
                array_merge(
                    $data,
                    ['student_id' => $student['id']]
                )
            );
            $student = Student::where('id', $student['id'])->with('parent')->first();
            $subject = Subject::where('id', $data['subject_id'])->first();
            Mail::to($student->parent->email)->queue(new SituationMail(array_merge($data, ['student' => $student, 'subject' => $subject, 'situation' => $dataCreated])));
//            dispatch(new SendSituationEmail($student->parent->email, $data));
        }
        return [
            'message' => 1
        ];
    }

    public function update($id, $data)
    {
        return $this->situationRepo->update($id, $data);
    }

    public function delete($id)
    {
        $situation = $this->situationRepo->find($id);
        return $situation->delete();
    }
}
