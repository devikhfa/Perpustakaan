<!DOCTYPE html>
<html>
<head>
    <title>Struk Denda</title>
    <style>
        body {
            font-family: monospace;
        }
        .struk {
            width: 300px;
            margin: auto;
            border: 1px dashed #000;
            padding: 15px;
        }
        h3 {
            text-align: center;
        }
        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    </style>
</head>
<body onload="window.print()">

<div class="struk">
    <h3>STRUK DENDA</h3>

    <div class="line"></div>

    <p><b>Nama:</b><br>{{ $transaksi->nama_pengguna }}</p>
    <p><b>Buku:</b><br>{{ $transaksi->judul }}</p>

    <div class="line"></div>

    <p><b>Tgl Pinjam:</b><br>{{ $transaksi->tgl_pinjam }}</p>
    <p><b>Jatuh Tempo:</b><br>{{ $transaksi->tgl_jatuh_tempo }}</p>
    <p><b>Dikembalikan:</b><br>{{ $transaksi->tgl_dikembalikan }}</p>

    <div class="line"></div>

    <h4>Total Denda:</h4>
    <h2>Rp {{ number_format($transaksi->denda ?? 0, 0, ',', '.') }}</h2>

    <div class="line"></div>

    <p style="text-align:center;">Terima kasih 🙏</p>
</div>

</body>
</html>