<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        $transactionNumber = 'TRX-' . date('Ymd-His');

        return view('cashier.index', compact(
            'products',
            'transactionNumber'
        ));
    }
}