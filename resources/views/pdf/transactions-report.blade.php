<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        @page {
            margin: 40px 45px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #855300;
            margin: 0;
            padding: 0;
            letter-spacing: 0.5px;
        }

        .header .subtitle {
            font-size: 12px;
            color: #4b5563;
            margin-top: 4px;
            font-weight: normal;
        }

        .header-line {
            border-top: 3px solid #855300;
            margin-top: 15px;
            margin-bottom: 20px;
            width: 100%;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .meta-table td {
            padding: 4px 0;
            font-size: 11px;
            vertical-align: middle;
        }

        .meta-table td.label {
            font-weight: bold;
            width: 110px;
            color: #1f2937;
        }

        .meta-table td.colon {
            width: 15px;
            color: #1f2937;
            text-align: left;
        }

        .meta-table td.value {
            color: #1f2937;
        }

        .meta-divider {
            border-top: 1px solid #e5e7eb;
            margin-bottom: 25px;
            width: 100%;
        }

        .summary-card {
            border: 1px solid #ffd09a;
            border-radius: 8px;
            padding: 15px 20px;
            background-color: #fffcf9;
            margin-bottom: 25px;
        }

        .summary-card-title {
            font-size: 11px;
            font-weight: bold;
            color: #855300;
            text-transform: uppercase;
            margin: 0 0 10px 0;
            letter-spacing: 0.5px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px 0;
            font-size: 11px;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
            vertical-align: middle;
        }

        .summary-table tr.grand-total td {
            padding-top: 12px;
            border-bottom: none;
            border-top: 1px solid #ffd09a;
        }

        .summary-table td.count {
            color: #6b7280;
            font-size: 10px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #855300;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table th {
            background-color: #fffbeb;
            color: #534434;
            padding: 10px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #ffd09a;
        }

        .data-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
            color: #1f2937;
            vertical-align: middle;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-size: 12px;
            border: 1px dashed #e5e7eb;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI</h1>
        <div class="subtitle">{{ config('app.name', 'LajuPesan') }}</div>
    </div>
    
    <div class="header-line"></div>

    <table class="meta-table">
        <tr>
            <td class="label">Periode</td>
            <td class="colon">:</td>
            <td class="value">{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} – {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</td>
        </tr>
        @if($storeName)
        <tr>
            <td class="label">Nama Toko</td>
            <td class="colon">:</td>
            <td class="value">{{ $storeName }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Tanggal Cetak</td>
            <td class="colon">:</td>
            <td class="value">{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
    </table>

    <div class="meta-divider"></div>

    @if($transactions->count() > 0)
    <div class="summary-card">
        <div class="summary-card-title">Ringkasan</div>
        <table class="summary-table">
            <tr>
                <td style="width: 40%;">Jumlah Transaksi</td>
                <td class="count" style="width: 30%;"></td>
                <td style="width: 30%; text-align: right; font-weight: bold;">{{ $transactions->count() }} transaksi</td>
            </tr>
            <tr>
                <td>Total Transaksi Tunai</td>
                <td class="count">({{ $totalCash['count'] }} transaksi)</td>
                <td style="text-align: right; font-weight: bold;">Rp{{ number_format($totalCash['amount'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Transaksi Non Tunai</td>
                <td class="count">({{ $totalNonCash['count'] }} transaksi)</td>
                <td style="text-align: right; font-weight: bold;">Rp{{ number_format($totalNonCash['amount'], 0, ',', '.') }}</td>
            </tr>
            <tr class="grand-total">
                <td colspan="2" style="font-weight: bold; font-size: 12px; color: #1f2937; text-transform: uppercase;">TOTAL OMSET</td>
                <td style="text-align: right; font-weight: bold; font-size: 22px; color: #855300;">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Detail Transaksi Berhasil</div>
    <table class="data-table">
        <thead>
            <tr>
                @if(!$storeName && $role === 'admin')
                <th style="width: 5%; text-align: left;">No</th>
                <th style="width: 15%;">Kode Transaksi</th>
                <th style="width: 15%;">Pelanggan</th>
                <th style="width: 15%;">Toko</th>
                <th style="width: 8%; text-align: center;">Meja</th>
                <th style="width: 10%;">Metode</th>
                <th style="width: 17%;">Tanggal</th>
                <th style="width: 15%; text-align: right;">Total</th>
                @else
                <th style="width: 5%; text-align: left;">No</th>
                <th style="width: 18%;">Kode Transaksi</th>
                <th style="width: 20%;">Pelanggan</th>
                <th style="width: 10%; text-align: center;">Meja</th>
                <th style="width: 12%;">Metode</th>
                <th style="width: 20%;">Tanggal</th>
                <th style="width: 15%; text-align: right;">Total</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $transaction)
            <tr>
                <td style="text-align: left;">{{ $index + 1 }}</td>
                <td>{{ $transaction->code }}</td>
                <td>{{ $transaction->name }}</td>
                @if(!$storeName && $role === 'admin')
                <td>{{ $transaction->user->name ?? '-' }}</td>
                @endif
                <td style="text-align: center;">{{ $transaction->table_number }}</td>
                <td>{{ $transaction->payment_method === 'cash' ? 'Tunai' : 'Non Tunai' }}</td>
                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td style="text-align: right; font-weight: bold;">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        Tidak ada data transaksi untuk periode yang dipilih.
    </div>
    @endif
</body>
</html>
