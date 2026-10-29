<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function generate()
    {
        // Data transaksi contoh untuk praktikum
        $invoice = [
            'nomor' => 'INV-20261029-001',
            'tanggal' => now()->format('d-m-Y H:i'),
            'kasir' => 'Admin Minimarket',
            'items' => [
                [
                    'nama' => 'Buku Tulis',
                    'jumlah' => 2,
                    'harga' => 5000,
                ],
                [
                    'nama' => 'Pulpen',
                    'jumlah' => 3,
                    'harga' => 3000,
                ],
                [
                    'nama' => 'Penghapus',
                    'jumlah' => 1,
                    'harga' => 2000,
                ],
            ],
        ];

        // Menghitung total belanja
        $total = 0;

        foreach ($invoice['items'] as $item) {
            $total += $item['jumlah'] * $item['harga'];
        }

        // Membuat dokumen PDF dari Blade View
        $pdf = Pdf::loadView('invoices.invoice', [
            'invoice' => $invoice,
            'total' => $total,
        ]);

        // Mengatur ukuran kertas A4
        $pdf->setPaper('a4', 'portrait');

        // Menampilkan PDF pada browser
        return $pdf->stream('invoice-minimarket.pdf');
    }
}