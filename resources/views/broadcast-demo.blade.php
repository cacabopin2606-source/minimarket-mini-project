
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Demo Reverb - Minimarket</title>

    @vite(['resources/js/app.js'])

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        button {
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        #notifications {
            margin-top: 20px;
        }

        .notification {
            padding: 15px;
            margin-top: 10px;
            background: #dcfce7;
            border-left: 4px solid #16a34a;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Minimarket - Demo Reverb</h2>

    <p>Simulasi notifikasi transaksi secara real-time.</p>

    @if (session('success'))
        <p style="color: green">
            {{ session('success') }}
        </p>
    @endif

    <form action="{{ route('broadcast.demo.send') }}" method="POST">
        @csrf
        <button type="submit">
            Simulasikan Transaksi
        </button>
    </form>

    <hr>

    <h3>Notifikasi Transaksi</h3>

    <div id="notifications">
        <p>Menunggu transaksi baru...</p>
    </div>

</div>

<script>
    window.addEventListener('load', function () {

        window.Echo.channel('demo-orders')
            .listen('.order.placed', (event) => {

                const container = document.getElementById('notifications');

                const notification = document.createElement('div');
                notification.className = 'notification';

                notification.innerHTML = `
                    <strong>Transaksi Baru!</strong><br>
                    Nomor: ${event.nomor}<br>
                    Kasir: ${event.kasir}<br>
                    Total: Rp${Number(event.total).toLocaleString('id-ID')}
                `;

                container.prepend(notification);
            });

    });
</script>

</body>
</html>
