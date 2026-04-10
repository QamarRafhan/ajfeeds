<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $order->reference_no }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            background: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 28px;
            font-weight: 900;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .company-info {
            text-align: right;
            font-size: 11px;
            color: #666;
        }

        .invoice-details {
            margin-bottom: 40px;
            display: table;
            width: 100%;
        }

        .detail-item {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .detail-item h4 {
            margin: 0 0 5px 0;
            color: #6366f1;
            text-transform: uppercase;
            font-size: 11px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background: #f8fafc;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #e2e8f0;
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .items-table .text-right {
            text-align: right;
        }

        .summary-table {
            width: 250px;
            margin-left: auto;
            margin-top: 20px;
        }

        .summary-table td {
            padding: 8px 12px;
            font-size: 13px;
        }

        .summary-table .total-row {
            background: #6366f1;
            color: #fff;
            font-weight: bold;
        }

        .status-stamp {
            display: inline-block;
            padding: 5px 15px;
            border: 3px solid;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            transform: rotate(-10deg);
            margin: 20px 0;
            font-size: 14px;
        }

        .status-paid {
            border-color: #22c55e;
            color: #22c55e;
        }

        .status-unpaid {
            border-color: #ef4444;
            color: #ef4444;
        }

        .status-partial {
            border-color: #f59e0b;
            color: #f59e0b;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        @media print {
            body {
                padding: 0;
            }

            .invoice-box {
                border: none;
                box-shadow: none;
                width: 100% !important;
                max-width: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <div class="logo">AJ-FEEDS</div>
            <div class="company-info">
                <strong>INVENTORY SYSTEM</strong><br>
                {{ config('app.url') }}<br>
                Date: {{ $order->created_at->format('M d, Y H:i') }}
            </div>
        </div>

        <div class="invoice-details">
            <div class="detail-item">
                <h4>Billed To</h4>
                <strong>{{ $order->customer->name ?? 'Walk-in Customer' }}</strong><br>
                {{ $order->customer->phone ?? '' }}<br>
                {{ $order->customer->email ?? '' }}<br>
                {{ $order->customer->address ?? '' }}
            </div>
            <div class="detail-item" style="text-align: right;">
                <h4>Invoice Reference</h4>
                <strong>#{{ $order->reference_no }}</strong><br>
                Cashier: {{ $order->user->name ?? 'System' }}<br>
                Payment Status: {{ strtoupper($order->payment_status) }}
            </div>
        </div>

        @php
            $stamp_class = match ($order->payment_status) {
                'paid' => 'status-paid',
                'partial' => 'status-partial',
                default => 'status-unpaid',
            };
        @endphp
        <div style="text-align: center;">
            <div class="status-stamp {{ $stamp_class }}">{{ $order->payment_status }}</div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Unknown item' }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <td>Subtotal</td>
                <td class="text-right">{{ env('CURRENCY_SIGN') }}{{ number_format($order->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Amount Paid</td>
                <td class="text-right text-green-600">
                    {{ env('CURRENCY_SIGN') }}{{ number_format($order->paid_amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Balance Due</td>
                <td class="text-right">
                    {{ env('CURRENCY_SIGN') }}{{ number_format($order->total_amount - $order->paid_amount, 2) }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for your business! This is a system-generated invoice.</p>
        </div>
    </div>
</body>

</html>
