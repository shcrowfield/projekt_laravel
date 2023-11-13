<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\Categories;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Transactions::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'trans_name' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'description' => 'required',
            'is_income' => 'required',
            'trans_date' => 'required'
        ]);

        return Transactions::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Transactions::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transactions = Transactions::find($id);
        $transactions->update($request->all());
        return $transactions;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Transactions::destroy($id);
    }

     /**
     * Search for a name
     * @param str $name
     */

    public function searchName($name){
        return Transactions::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->get();
    }

    public function searchProperty($name){
        return Transactions::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->whereNotIn('category_id', [9, 10])
        ->get();
    }

    public function searchCategory($category){
        return Transactions::whereHas('categories', function ($query) use ($category) {
            $query->where('category_name', 'like', '%' . $category . '%');
        })->get();
    }

    public function searchByNameAndCategory($name, $category) {
        return Transactions::whereHas('user', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('category_name', 'like', '%' . $category . '%');
            })
            ->get();
    }
    
}
