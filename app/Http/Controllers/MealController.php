<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use App\Services\MealService;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function __construct(protected MealService $mealService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $sorts = $request->input('sorts', []);
        $search = $request->input('search', []);
        $limit = $request->input('limit', 10);
        $list = $this->mealService->getList($filters, $sorts, $search, $limit);

        return response()->json(['code' => 200, 'data' => MealResource::collection($list)]);
    }

    public function show($id)
    {
        $meal = $this->mealService->getDetail($id);
        return response()->json(['code' => 200, 'data' => new MealResource($meal)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $meal = $this->mealService->create($data);
        return response()->json(['code' => 200, 'data' => $meal]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $meal = $this->mealService->update($id, $data);
        return response()->json(['code' => 200, 'data' => $meal]);
    }

    public function destroy($id)
    {
        $meal = $this->mealService->delete($id);
        return response()->json(['code' => 200, 'data' => $meal]);
    }
}
