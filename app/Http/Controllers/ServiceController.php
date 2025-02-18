<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    // Display all ISBN Requests
    public function index()
    {
        return view('services.index');
    }

    // Show the form for creating a new ISBN request
    public function create()
    {
        return view('services.create');
    }

    public function show($id)
    {
        return view('services.show', compact('id'));
    }

    public function edit($id)
    {
        return view('services.edit', compact('id'));
    }

    public function categories()
    {
        return view('admin.services.category');
    }
    public function brands()
    {
        return view('admin.services.brand');
    }

    public function sub_categories()
    {
        return view('admin.services.sub_category');
    }

    public function images($id)
    {
        $item = Service::findOrFail($id);
        return view('admin.services.image', [
            'item' => $item,
        ]);
    }
}
