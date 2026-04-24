<!DOCTYPE html>
<html>
<head>
    <title>Laporan Piutang</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0d6efd; /* 🔥 warna branding */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo img {
            height: 50px;
        }

        .company {
            text-align: right;
        }

        .company h2 {
            margin: 0;
            color: #0d6efd;
        }

        .info {
            margin-bottom: 15px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #0d6efd;
            color: white;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .subtotal {
            background-color: #f1f5f9;
            font-weight: bold;
        }

        .total {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
        }

        .summary {
            margin-top: 15px;
            padding: 10px;
            background: #f8fafc;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<!-- 🔥 HEADER -->
<div class="header">
    <div class="logo">
        <!-- GANTI LOGO -->
        <img src="{{ public_path('logo.png') }}">
    </div>

    <div class="company">
        <h2>PIUFY</h2>
        <p>Laporan Piutang</p>
    </div>
</div>

<!-- 🔥 INFO -->
<div class="info">
    <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

    <p>
        <strong>Periode:</strong>
        @if($minDate && $maxDate)
            {{ \Carbon\Carbon::parse($minDate)->translatedFormat('d F Y') }}
            s/d
            {{ \Carbon\Carbon::parse($maxDate)->translatedFormat('d F Y') }}
        @else
            Tidak ada data
        @endif
    </p>
</div>

@php
    $grouped = [];
    $totalQty = 0;
    $totalNilai = 0;

    foreach ($data as $item) {
        $status = $item->status ?? '-';

        if (!isset($grouped[$status])) {
            $grouped[$status] = [];
        }

        $grouped[$status][] = $item;
    }
@endphp

<!-- 🔥 TABLE -->
<table>
    <thead>
        <tr>
            <th>Status</th>
            <th>Nama Klien</th>
            <th class="text-center">Jumlah</th>
            <th class="text-end">Nilai Piutang</th>
        </tr>
    </thead>

    <tbody>

    @foreach($grouped as $status => $items)

        @php
            $subtotalQty = 0;
            $subtotalNilai = 0;
        @endphp

        @foreach($items as $item)

            @php
                $nilai = $item->nilai_tagihan ?? $item->nilai_piutang ?? 0;
                $subtotalQty++;
                $subtotalNilai += $nilai;
            @endphp

            <tr>
                <td>{{ $status }}</td>
                <td>{{ $item->nama_klien }}</td>
                <td class="text-center">1</td>
                <td class="text-end">
                    Rp{{ number_format($nilai, 0, ',', '.') }}
                </td>
            </tr>

        @endforeach

        <!-- SUBTOTAL -->
        <tr class="subtotal">
            <td colspan="2">Subtotal {{ ucfirst($status) }}</td>
            <td class="text-center">{{ $subtotalQty }}</td>
            <td class="text-end">
                Rp{{ number_format($subtotalNilai, 0, ',', '.') }}
            </td>
        </tr>

        @php
            $totalQty += $subtotalQty;
            $totalNilai += $subtotalNilai;
        @endphp

    @endforeach

    <!-- TOTAL -->
    <tr class="total">
        <td colspan="2">TOTAL KESELURUHAN</td>
        <td class="text-center">{{ $totalQty }}</td>
        <td class="text-end">
            Rp{{ number_format($totalNilai, 0, ',', '.') }}
        </td>
    </tr>

    </tbody>
</table>

<!-- 🔥 SUMMARY -->
<div class="summary">
    <p><strong>Total Transaksi:</strong> {{ $totalQty }}</p>
    <p><strong>Total Nilai Piutang:</strong> Rp{{ number_format($totalNilai, 0, ',', '.') }}</p>
</div>

</body>
</html>