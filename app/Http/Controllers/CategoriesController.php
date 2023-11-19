<?php

namespace App\Http\Controllers;
use App\Models\Categories;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Categories::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

           $request->validate([
               'category_name' => 'required'
           ]);
           return Categories::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Categories::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categories = Categories::find($id);
        $categories->update($request->all());
        return $categories;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Categories::destroy($id);
    }
}
