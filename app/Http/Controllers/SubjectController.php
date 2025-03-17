<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubjectResource;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(protected SubjectService $subjectService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $sorts = $request->input('sorts', []);
        $search = $request->input('search', []);
        $limit = $request->input('limit', 10);
        $list = $this->subjectService->getList($filters, $sorts, $search, $limit);

        return response()->json(['code' => 200, 'data' => SubjectResource::collection($list)]);
    }

    public function show($id)
    {
        $subject = $this->subjectService->getDetail($id);
        return response()->json(['code' => 200, 'data' => new SubjectResource($subject)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $subject = $this->subjectService->create($data);
        return response()->json(['code' => 200, 'data' => $subject]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $subject = $this->subjectService->update($id, $data);
        return response()->json(['code' => 200, 'data' => $subject]);
    }

    public function destroy($id)
    {
        $subject = $this->subjectService->delete($id);
        return response()->json(['code' => 200, 'data' => $subject]);
    }
}
