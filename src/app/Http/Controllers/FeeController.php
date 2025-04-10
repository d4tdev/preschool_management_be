<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeeResource;
use App\Services\FeeService;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function __construct(protected FeeService $feeService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $sorts = $request->input('sorts', []);
        $search = $request->input('search', []);
        $limit = $request->input('limit', 10);
        $list = $this->feeService->getList($filters, $sorts, $search, $limit);

        return response()->json(['code' => 200, 'data' => FeeResource::collection($list)]);
    }

    public function show($id)
    {
        $fee = $this->feeService->getDetail($id);
        return response()->json(['code' => 200, 'data' => new FeeResource($fee)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $fee = $this->feeService->create($data);
        return response()->json(['code' => 200, 'data' => $fee]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $fee = $this->feeService->update($id, $data);
        return response()->json(['code' => 200, 'data' => $fee]);
    }

    public function destroy($id)
    {
        $fee = $this->feeService->delete($id);
        return response()->json(['code' => 200, 'data' => $fee]);
    }
}
