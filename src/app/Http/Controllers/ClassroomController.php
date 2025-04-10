<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassroomResource;
use App\Services\ClassroomService;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function __construct(protected ClassroomService $classroomService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $sorts = $request->input('sorts', []);
        $search = $request->input('search', []);
        $limit = $request->input('limit', 10);
        $list = $this->classroomService->getList($filters, $sorts, $search, $limit);

        return response()->json(['code' => 200, 'data' => ClassroomResource::collection($list)]);
    }

    public function show($id)
    {
        $classroom = $this->classroomService->getDetail($id);
        return response()->json(['code' => 200, 'data' => new ClassroomResource($classroom)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $classroom = $this->classroomService->create($data);
        return response()->json(['code' => 200, 'data' => $classroom]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $classroom = $this->classroomService->update($id, $data);
        return response()->json(['code' => 200, 'data' => $classroom]);
    }

    public function destroy($id)
    {
        $classroom = $this->classroomService->delete($id);
        return response()->json(['code' => 200, 'data' => $classroom]);
    }
}
