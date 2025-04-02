<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerCredit;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Customers = Customer::with('packages')->get();

        return response()->json($Customers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function updateCredit(Request $request, string $id)
    {
        $validated = $request->validate([
            'action' => 'required|in:add,minus', // Ensure action is only 'add' or 'minus'
            'amount' => 'required|numeric',
            'credit' => 'required|numeric',
        ]);

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        // Create a new credit transaction
        CustomerCredit::create([
            'customer_id' => $id,
            'action' => $request->action,
            'add_by_user_id' => $request->user()->id,
            'amount' => $request->amount,
            'status' => 1,
            'credit' => $request->credit,
        ]);

        // Update customer credit balance
        $newCredit = $request->action == 'add'
            ? $customer->credit + $request->credit
            : $customer->credit - $request->credit;

        $customer->update([
            'credit' => $newCredit,
            'updated_user_id' => $request->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Credit adjusted successfully.',
            'new_credit' => $newCredit,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
