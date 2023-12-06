<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Transactions;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return User::destroy($id);
    }

    public function findMoney($name)
    {
        //megkeresi a paraméterben kapott névvel rendelkező felhasználót
        $transactions = Transactions::whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->get();

        // Kiszedi a user_id-kat a tranzakciókból
        $userIds = $transactions->pluck('user_id')->unique();

        // Lekéri a felhasználókat
        $users = User::whereIn('id', $userIds)
            ->with('transactions')
            ->get();
        $netMoneyResults = [];

        $users->each(function ($user) use (&$netMoneyResults) {
            $expenses = $user->transactions->where('is_income', 0)->sum('price');
            $income = $user->transactions->where('is_income', 1)->sum('price');
            $netMoney = $user->money - $expenses + $income;

            $netMoneyResults[] = [
                'user_id' => $user->id,
                'name' => $user->name,
                'net_money' => $netMoney,
            ];
        });
        return $netMoneyResults;

    }

}
