<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAllocationRequest;
use App\Http\Requests\UpdateAllocationRequest;
use App\Http\Resources\AllocationResource;
use App\Models\Allocation;
use App\Models\Budget;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    public function index(Budget $budget)
    {
        $this->authorize('viewAny', [Allocation::class, $budget]);

        return AllocationResource::collection(
            $budget->allocations()->with('category', 'expenses')->get()
        );
    }

    public function store(StoreAllocationRequest $request, Budget $budget)
    {
        $this->authorize('create', [Allocation::class, $budget]);

        $allocation = Allocation::create([
            ...$request->validated(),
            'budget_id' => $budget->id,
        ]);

        return new AllocationResource($allocation->load('category'));
    }

    public function update(UpdateAllocationRequest $request, Budget $budget, Allocation $allocation)
    {
        $this->authorize('update', $allocation);

        $allocation->update($request->validated());

        return new AllocationResource($allocation->load('category'));
    }

    public function destroy(Budget $budget, Allocation $allocation)
    {
        $this->authorize('delete', $allocation);

        $allocation->delete();

        return response()->noContent();
    }
}
