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
            'action' => 'required',
            'amount' => 'required',
            'credit' => 'required',
        ]);

        $customer = Customer::find($id);

        // dd($validated);

        CustomerCredit::create([
            'customer_id' => $id,
            'action' => $request->action,
            'add_by_user_id' => request()->user()->id,
            'amount' => $request->amount,
            'credit' => $request->credit,
        ]);

        $customer->update([
            'credit' => $request->action == 'add' ? $customer->credit + $request->credit : $customer->credit - $request->credit,
            'updated_user_id' => request()->user()->id,
        ]);

        return response()->json('success', 'Adjust Credit Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
