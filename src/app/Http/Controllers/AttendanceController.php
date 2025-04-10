<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceResource;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $sorts = $request->input('sorts', []);
        $search = $request->input('search', []);
        $limit = $request->input('limit', 10);
        $list = $this->attendanceService->getList($filters, $sorts, $search, $limit);

        return response()->json(['code' => 200, 'data' => AttendanceResource::collection($list)]);
    }

    public function show($id)
    {
        $attendance = $this->attendanceService->getDetail($id);
        return response()->json(['code' => 200, 'data' => new AttendanceResource($attendance)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $attendance = $this->attendanceService->createOrUpdate($data);
        return response()->json(['code' => 200, 'data' => $attendance]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $attendance = $this->attendanceService->update($id, $data);
        return response()->json(['code' => 200, 'data' => $attendance]);
    }

    public function destroy($id)
    {
        $attendance = $this->attendanceService->delete($id);
        return response()->json(['code' => 200, 'data' => $attendance]);
    }
}
