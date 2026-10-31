<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderPlaced;

class BroadcastDemoController extends Controller
{
    public function index()
    {
        return view('broadcast-demo');
    }

    public function send()
    {
        $nomor = 'INV-' . date('YmdHis');

        event(new OrderPlaced(
            $nomor,
            'Kasir Minimarket',
            75000
        ));

        return redirect()->route('broadcast.demo')
            ->with('success', 'Notifikasi transaksi berhasil dikirim!');
    }
}
