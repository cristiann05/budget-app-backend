<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
use App\Http\Resources\BudgetResource;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Budget::class);

        $budgets = Budget::where('user_id', $request->user()->id)
            ->with('allocations.category')
            ->get();

        return BudgetResource::collection($budgets);
    }

    public function store(StoreBudgetRequest $request)
    {
        $this->authorize('create', Budget::class);

        $budget = Budget::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return new BudgetResource($budget);
    }

    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);

        return new BudgetResource($budget->load('allocations.category'));
    }

    public function update(UpdateBudgetRequest $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $budget->update($request->validated());

        return new BudgetResource($budget->load('allocations.category'));
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);

        $budget->delete();

        return response()->noContent();
    }
}
