<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Invoice Minimarket</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin-bottom: 5px;
            font-size: 24px;
        }

        .header p {
            margin-top: 0;
        }

        .info {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #999;
            padding: 9px;
        }

        th {
            background-color: #eeeeee;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .total {
            margin-top: 15px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }

        .footer {
            margin-top: 35px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>MINIMARKET</h1>
        <p>Invoice Pembelian Barang</p>
        <hr>
    </div>

    <div class="info">
        <strong>Nomor Invoice:</strong>
        {{ $invoice['nomor'] }}<br>

        <strong>Tanggal:</strong>
        {{ $invoice['tanggal'] }}<br>

        <strong>Kasir:</strong>
        {{ $invoice['kasir'] }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($invoice['items'] as $index => $item)
                <tr>
                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $item['nama'] }}
                    </td>

                    <td class="center">
                        {{ $item['jumlah'] }}
                    </td>

                    <td class="right">
                        Rp{{ number_format($item['harga'], 0, ',', '.') }}
                    </td>

                    <td class="right">
                        Rp{{ number_format(
                            $item['jumlah'] * $item['harga'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Pembayaran:
        Rp{{ number_format($total, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja.</p>
        <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>
    </div>

</body>
</html>