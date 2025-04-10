<?php

namespace App\Services;

use App\Mail\AttendanceMail;
use App\Models\Attendance;
use App\Models\Student;
use App\Repositories\Criteria\Attendance\SortAndFilterAttendanceCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Mail;

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
        $res = $this->attendanceRepo->updateOrCreate(['student_id' => $data['student_id'], 'date' => $data['date']], $data);
        $student = Student::where('id', $data['student_id'])->with(['parent', 'class.teacher'])->first();

        Mail::to($student->parent->email)->queue(new AttendanceMail($data, $student));
        return $res;
    }

    public function delete($id)
    {
        $attendance = $this->attendanceRepo->find($id);
        return $attendance->delete();
    }
}
