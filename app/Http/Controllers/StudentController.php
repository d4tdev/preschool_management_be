<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(protected StudentService $studentService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $sorts = $request->input('sorts', []);
        $search = $request->input('search', []);
        $limit = $request->input('limit', 10);
        $list = $this->studentService->getList($filters, $sorts, $search, $limit);

        return response()->json(['code' => 200, 'data' => StudentResource::collection($list)]);
    }

    public function show($id)
    {
        $student = $this->studentService->getDetail($id);
        return response()->json(['code' => 200, 'data' => new StudentResource($student)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $student = $this->studentService->create($data);
        return response()->json(['code' => 200, 'data' => $student]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $student = $this->studentService->update($id, $data);

        return response()->json(['code' => 200, 'data' => "success"]);
    }

    public function destroy($id)
    {
        $student = $this->studentService->delete($id);
        return response()->json(['code' => 200, 'data' => $student]);
    }
}
