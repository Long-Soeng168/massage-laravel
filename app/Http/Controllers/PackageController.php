<?php

namespace App\Http\Controllers;

class PackageController extends Controller
{
     // Display all ISBN Requests
     public function index()
     {
         return view('packages.index');
     }
     public function stocks()
     {
         return view('packages.stock');
     }

     // Show the form for creating a new ISBN request
     public function create()
     {
         return view('packages.create');
     }

     public function show($id)
     {
         return view('packages.show', compact('id'));
     }

     public function edit($id)
     {
        return view('packages.edit', compact('id'));
     }

     public function categories()
    {
        return view('admin.packages.category');
    }

    public function sub_categories()
    {
        return view('admin.packages.sub_category');
    }


}
