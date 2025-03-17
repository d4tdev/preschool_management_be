<?php

namespace App\Services;

use App\Models\Schedule;
use App\Repositories\Criteria\Schedule\SortAndFilterScheduleCriteria;
use App\Repositories\Repository;
use App\Services\AbstractService;

class ScheduleService extends AbstractService {
    protected Repository $scheduleRepo;
    public function __construct(Schedule $schedule)
    {
        $this->scheduleRepo = new Repository($schedule);
    }

    public function getList($filters, $sorts, $search, $limit)
    {
        return $this->scheduleRepo->pushCriteria(
            new SortAndFilterScheduleCriteria($filters, $sorts, $search)
        )->paginate($limit);
    }

    public function getDetail($id)
    {
        return $this->scheduleRepo->with(['createdBy', 'updatedBy'])->find($id);
    }

    public function create($data)
    {
        return $this->scheduleRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->scheduleRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->scheduleRepo->delete($id);
    }
}
