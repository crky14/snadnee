<?php


namespace App\Http\Controllers;


use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Show index page with all transactions
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $transactions = Transaction::all();
        return view('main', ['transactions' => $transactions]);
    }
}
