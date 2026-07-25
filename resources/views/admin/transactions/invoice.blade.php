{{-- resources/views/admin/transactions/invoice.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $transaction->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            padding: 2rem;
            color: #1a1c23;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .invoice-header {
            padding: 2rem;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .invoice-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .invoice-brand .logo {
            width: 40px;
            height: 40px;
            background: #00D27A;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }
        .invoice-brand h1 {
            font-size: 24px;
            font-weight: 700;
        }
        .invoice-status {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .invoice-status.completed {
            background: #e8fcf0;
            color: #00D27A;
        }
        .invoice-status.cancelled {
            background: #fce8e8;
            color: #dc3545;
        }
        .invoice-status.pending {
            background: #fff3cd;
            color: #ffc107;
        }
        .invoice-body {
            padding: 2rem;
        }
        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .invoice-info h3 {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .invoice-info p {
            font-size: 15px;
            line-height: 1.6;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }
        .invoice-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            background: #f8f9fa;
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }
        .invoice-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }
        .invoice-table .text-right {
            text-align: right;
        }
        .invoice-total {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
        }
        .invoice-total-content {
            width: 250px;
        }
        .invoice-total-content .row {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            font-size: 14px;
        }
        .invoice-total-content .row.total {
            font-size: 18px;
            font-weight: 700;
            border-top: 2px solid #e9ecef;
            padding-top: 0.75rem;
            margin-top: 0.5rem;
            color: #00D27A;
        }
        .invoice-footer {
            padding: 1.5rem 2rem;
            background: #f8f9fa;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
        .invoice-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin-top: 1.5rem;
        }
        .btn {
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }
        .btn-primary {
            background: #00D27A;
            color: white;
        }
        .btn-primary:hover {
            background: #00B868;
        }
        .btn-secondary {
            background: #f0f0f0;
            color: #1a1c23;
        }
        .btn-secondary:hover {
            background: #e0e0e0;
        }
        @media print {
            body { background: white; padding: 0; }
            .invoice-actions { display: none; }
            .invoice-container { box-shadow: none; border-radius: 0; }
            .invoice-status { print-color-adjust: exact; }
        }
        @media (max-width: 640px) {
            .invoice-header { flex-direction: column; gap: 1rem; text-align: center; }
            .invoice-info { grid-template-columns: 1fr; gap: 1rem; }
            .invoice-table { font-size: 13px; }
            .invoice-table th, .invoice-table td { padding: 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="invoice-container" id="invoice">
        <!-- Header -->
        <div class="invoice-header">
            <div class="invoice-brand">
                <div class="logo">C</div>
                <h1>CoreSite</h1>
            </div>
            <div>
                <span class="invoice-status {{ $transaction->status }}">
                    {{ ucfirst($transaction->status) }}
                </span>
                <div style="margin-top: 0.25rem; font-size: 14px; color: #6c757d;">
                    #{{ $transaction->invoice_number }}
                </div>
            </div>
        </div>
        
        <!-- Body -->
        <div class="invoice-body">
            <!-- Info -->
            <div class="invoice-info">
                <div>
                    <h3>Informasi Toko</h3>
                    <p>
                        <strong>{{ $transaction->store->name }}</strong><br>
                        {{ $transaction->store->email }}<br>
                        {{ $transaction->store->phone ?? '-' }}
                    </p>
                </div>
                <div>
                    <h3>Informasi Transaksi</h3>
                    <p>
                        <strong>Tanggal:</strong> {{ $transaction->transaction_date->format('d/m/Y H:i') }}<br>
                        <strong>Metode:</strong> 
                        @if($transaction->payment_method === 'cash') Tunai
                        @elseif($transaction->payment_method === 'transfer') Transfer Bank
                        @elseif($transaction->payment_method === 'qris') QRIS
                        @else {{ $transaction->payment_method }}
                        @endif
                        <br>
                        <strong>Status:</strong> 
                        @if($transaction->status === 'completed') Selesai
                        @elseif($transaction->status === 'cancelled') Dibatalkan
                        @else Pending
                        @endif
                    </p>
                </div>
            </div>
            
            <!-- Items -->
            <h3 style="font-size: 14px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">
                Item Transaksi
            </h3>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Total -->
            <div class="invoice-total">
                <div class="invoice-total-content">
                    <div class="row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="row">
                        <span>Dibayar</span>
                        <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
                    </div>
                    @if($transaction->change_amount > 0)
                        <div class="row">
                            <span>Kembalian</span>
                            <span style="color: #00D27A;">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Notes -->
            @if($transaction->notes)
                <div style="margin-top: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px; font-size: 14px; color: #6c757d;">
                    <strong>Catatan:</strong> {{ $transaction->notes }}
                </div>
            @endif
            
            <!-- Actions -->
            <div class="invoice-actions">
                <button onclick="window.print()" class="btn btn-primary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak / PDF
                </button>
                <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-secondary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="invoice-footer">
            <p>Terima kasih telah berbelanja di {{ $transaction->store->name }}</p>
            <p style="font-size: 12px; margin-top: 4px;">Invoice ini dibuat secara otomatis oleh CoreSite</p>
        </div>
    </div>
</body>
</html>