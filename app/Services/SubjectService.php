<?php

namespace App\Services;

use App\Models\Subject;
use App\Repositories\Criteria\Subject\SortAndFilterSubjectCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;

class SubjectService extends AbstractService {
    protected Repository $subjectRepo;
    public function __construct(Subject $subject)
    {
        $this->subjectRepo = new Repository($subject);
    }

    public function getList($filters, $sorts, $search, $limit)
    {
        return $this->subjectRepo->pushCriteria(
            new SortAndFilterSubjectCriteria($filters, $sorts, $search)
        )->all();
    }

    public function getDetail($id)
    {
        return $this->subjectRepo->with(['createdBy', 'updatedBy'])->find($id);
    }

    public function create($data)
    {
        return $this->subjectRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->subjectRepo->update($id, $data);
    }

    public function delete($id)
    {
        $subject = $this->subjectRepo->find($id);
        return $subject->delete();
    }
}
