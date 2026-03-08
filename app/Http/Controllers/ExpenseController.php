<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Allocation;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index(Allocation $allocation)
    {
        $this->authorize('viewAny', [Expense::class, $allocation]);

        return ExpenseResource::collection($allocation->expenses);
    }

    public function store(StoreExpenseRequest $request, Allocation $allocation)
    {
        $this->authorize('create', [Expense::class, $allocation]);

        $expense = Expense::create([
            ...$request->validated(),
            'allocation_id' => $allocation->id,
        ]);

        return new ExpenseResource($expense);
    }

    public function update(UpdateExpenseRequest $request, Allocation $allocation, Expense $expense)
    {
        $this->authorize('update', $expense);

        $expense->update($request->validated());

        return new ExpenseResource($expense);
    }

    public function destroy(Allocation $allocation, Expense $expense)
    {
        $this->authorize('delete', $expense);

        $expense->delete();

        return response()->noContent();
    }
}
