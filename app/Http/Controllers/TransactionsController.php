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
    public function destroy(string $trans_name)
    {
        return Transactions::where('trans_name', $trans_name)->delete();
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

    public function searchNameByMonth($name, $selectedMonth)
    {
        // Assuming $selectedMonth is in the format 'YYYY-MM'
        $startDate = $selectedMonth . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        return Transactions::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->whereBetween('trans_date', [$startDate, $endDate])
            ->get();
    }

    public function sumByNameAndEachCategoryAndMonth($name, $selectedMonth) {
        $startDate = $selectedMonth . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        $results = Transactions::with('categories:id,category_name')
            ->whereHas('user', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->whereBetween('trans_date', [$startDate, $endDate])
            ->where('is_income', '!=', 1)
            ->get();

        $categorySums = [];

        foreach ($results as $transaction) {
            $categoryId = $transaction->category_id;

            $category = Categories::find($categoryId);

            if ($category) {
                $categoryName = $category->category_name;
                $categoryPrice = $categorySums[$categoryName]['value'] ?? 0;
                $categorySums[$categoryName] = [
                    'category_name' => $categoryName,
                    'value' => $categoryPrice + $transaction->price,
                ];
            }
        }

        return array_values($categorySums);
    }




    public function searchProperty($name){
        return Transactions::whereIn('category_id', [1, 2, 3, 4, 5, 6, 7, 8, 11])
            ->whereHas('user', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->groupBy('user_id', 'trans_name')
            ->havingRaw('COUNT(trans_name) = 1')
            ->select('user_id', 'trans_name')
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

    public function sumByNameAndCategory($name, $category) {
        $result = Transactions::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('category_name', 'like', '%' . $category . '%');
            })
            ->where('is_income', '!=', 1)
            ->get();

        $totalSum = $result->sum('price');

        $data = [
            'total_sum' => $totalSum,
            'transactions' => $result,
        ];

        return $data;
    }


    public function sumIsincome($name, $is_income) {
        $result = Transactions::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->where('is_income', '=', $is_income)
            ->get();

        $totalSum = $result->sum('price');

        $data = [
            'total_sum' => $totalSum,
            'transactions' => $result,
        ];

        return $data;
    }



    public function listIsincome($name, $is_income){
        return Transactions::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->where('is_income', '=', $is_income)
            ->get();
    }

    public function lastOneOfCategory($name, $category){

        return Transactions::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('category_name', 'like', '%' . $category . '%');
            })
            ->latest('trans_date')
            ->first();
    }

}
