<?php

namespace App\Services;

use App\Models\Attendance;
use App\Repositories\Criteria\Attendance\SortAndFilterAttendanceCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;

class AttendanceService extends AbstractService {
    protected Repository $attendanceRepo;
    public function __construct(Attendance $attendance)
    {
        $this->attendanceRepo = new Repository($attendance);
    }

    public function getList($filters, $sorts, $search, $limit)
    {
        return $this->attendanceRepo->pushCriteria(
            new SortAndFilterAttendanceCriteria($filters, $sorts, $search)
        )->all();
    }

    public function getDetail($id)
    {
        return $this->attendanceRepo->with(['createdBy', 'updatedBy'])->find($id);
    }

    public function create($data)
    {
        return $this->attendanceRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->attendanceRepo->update($id, $data);
    }

    public function createOrUpdate($data)
    {
        return $this->attendanceRepo->updateOrCreate(['student_id' => $data['student_id'], 'date' => $data['date']], $data);
    }

    public function delete($id)
    {
        $attendance = $this->attendanceRepo->find($id);
        return $attendance->delete();
    }
}
