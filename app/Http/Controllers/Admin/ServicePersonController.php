<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicePersonController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view people', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:create people', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:update people', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete people', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.service_person.index');
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
    public function adjust_credits()
    {
        return view('admin.customers.adjust_credits');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
