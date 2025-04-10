<?php

namespace App\Http\Controllers;

use App\Http\Resources\SituationResource;
use App\Services\SituationService;
use Illuminate\Http\Request;

class SituationController extends Controller
{
    public function __construct(protected SituationService $situationService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $sorts = $request->input('sorts', []);
        $search = $request->input('search', []);
        $limit = $request->input('limit', 10);
        $list = $this->situationService->getList($filters, $sorts, $search, $limit);

        return response()->json(['code' => 200, 'data' => SituationResource::collection($list)]);
    }

    public function show($id)
    {
        $situation = $this->situationService->getDetail($id);
        return response()->json(['code' => 200, 'data' => new SituationResource($situation)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $situation = $this->situationService->create($data);
        return response()->json(['code' => 200, 'data' => $situation]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $situation = $this->situationService->update($id, $data);
        return response()->json(['code' => 200, 'data' => $situation]);
    }

    public function destroy($id)
    {
        $situation = $this->situationService->delete($id);
        return response()->json(['code' => 200, 'data' => $situation]);
    }
}
