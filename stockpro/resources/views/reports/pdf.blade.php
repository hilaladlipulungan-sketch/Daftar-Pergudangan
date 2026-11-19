<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Stok - StockPro</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #1f2937;
            font-size: 11px;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #2563EB;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 18px;
            color: #2563EB;
            margin: 0 0 4px 0;
        }
        .header p {
            margin: 0;
            color: #6b7280;
        }
        .meta {
            text-align: right;
        }
        .summary {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }
        .summary-box {
            flex: 1;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px 14px;
        }
        .summary-box p.label {
            margin: 0 0 4px 0;
            color: #6b7280;
            font-size: 10px;
        }
        .summary-box p.value {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }

        h2.section-title {
            font-size: 13px;
            background-color: #f3f4f6;
            padding: 8px 10px;
            margin: 20px 0 0 0;
            border-radius: 4px 4px 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        thead th {
            background-color: #f9fafb;
            text-align: left;
            padding: 6px 10px;
            font-size: 10px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }
        tbody td {
            padding: 6px 10px;
            border-bottom: 1px solid #f3f4f6;
        }
        .empty-row {
            text-align: center;
            color: #9ca3af;
            padding: 12px;
        }
        .footer {
            margin-top: 24px;
            text-align: center;
            color: #9ca3af;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h1>StockPro</h1>
            <p>Laporan Transaksi Stok</p>
        </div>
        <div class="meta">
            <p><strong>Jenis:</strong>
                {{ $type == 'all' ? 'Semua Transaksi' : ($type == 'in' ? 'Barang Masuk' : 'Barang Keluar') }}
            </p>
            <p><strong>Periode:</strong>
                {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d-m-Y') : 'Awal' }}
                s/d
                {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d-m-Y') : 'Sekarang' }}
            </p>
            <p><strong>Dicetak:</strong> {{ now()->format('d-m-Y H:i') }}</p>
        </div>
    </div>

    <div class="summary">
        <div class="summary-box">
            <p class="label">Total Barang Masuk</p>
            <p class="value text-green">+{{ $totalIn }} unit</p>
        </div>
        <div class="summary-box">
            <p class="label">Total Barang Keluar</p>
            <p class="value text-red">-{{ $totalOut }} unit</p>
        </div>
    </div>

    @if ($type == 'all' || $type == 'in')
        <h2 class="section-title">Barang Masuk</h2>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Supplier</th>
                    <th>Jumlah</th>
                    <th>Catatan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stockIns as $stockIn)
                    <tr>
                        <td>{{ $stockIn->product->name ?? '-' }}</td>
                        <td>{{ $stockIn->supplier->name ?? '-' }}</td>
                        <td class="text-green">+{{ $stockIn->quantity }}</td>
                        <td>{{ $stockIn->notes ?? '-' }}</td>
                        <td>{{ $stockIn->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-row">Tidak ada data pada rentang ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if ($type == 'all' || $type == 'out')
        <h2 class="section-title">Barang Keluar</h2>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Tujuan</th>
                    <th>Jumlah</th>
                    <th>Catatan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stockOuts as $stockOut)
                    <tr>
                        <td>{{ $stockOut->product->name ?? '-' }}</td>
                        <td>{{ $stockOut->destination ?? '-' }}</td>
                        <td class="text-red">-{{ $stockOut->quantity }}</td>
                        <td>{{ $stockOut->notes ?? '-' }}</td>
                        <td>{{ $stockOut->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-row">Tidak ada data pada rentang ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem StockPro.
    </div>

</body>
</html>