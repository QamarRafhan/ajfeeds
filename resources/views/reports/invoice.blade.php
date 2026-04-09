<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->reference_no }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            font-size: 14px;
            line-height: 24px;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-top: 5px solid #4f46e5;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-header table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .invoice-header table td.title {
            font-size: 38px;
            line-height: 38px;
            color: #111;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .invoice-header table td.company-details {
            text-align: right;
            font-size: 13px;
            color: #777;
        }

        .invoice-details {
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .invoice-details th,
        .invoice-details td {
            padding: 12px;
            border-bottom: 1px solid #f1f1f1;
            text-align: left;
        }

        .invoice-details th {
            background: #f9fafb;
            font-weight: bold;
            color: #374151;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .invoice-details td {
            color: #4b5563;
        }

        .invoice-details .text-right {
            text-align: right;
        }

        .total-row td {
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
            font-weight: 800;
            color: #111;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table class="invoice-header">
            <tr>
                <td class="title">INVOICE</td>
                <td class="company-details">
                    <strong style="color: #333; font-size: 15px;">Smart Inventory System</strong><br>
                    Global Operations Center<br>
                    support@inventory.local<br>
                    +1 (555) 019-2831
                </td>
            </tr>
        </table>

        <table style="margin-top: 40px;">
            <tr>
                <td style="border:none;">
                    <strong>Cashier Reference:</strong><br>
                    {{ $order->user->name ?? 'System Guest' }}<br>
                    <span style="color: #666; font-size: 12px;">{{ $order->user->email ?? 'N/A' }}</span>
                </td>
                <td style="border:none; text-align:right;">
                    <strong>Invoice #:</strong> {{ $order->reference_no }}<br>
                    <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}<br>
                    <strong>Status:</strong> <span
                        style="text-transform: capitalize; color: #059669; font-weight:bold;">{{ $order->status }}</span>
                </td>
            </tr>
        </table>

        <table class="invoice-details">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="width: 15%;">SKU</th>
                    <th class="text-right" style="width: 15%;">Unit Price</th>
                    <th class="text-right" style="width: 10%;">Qty</th>
                    <th class="text-right" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->items as $item)
                    <tr>
                        <td style="font-weight: 600;">{{ $item->product->name ?? 'Deleted Product' }}</td>
                        <td style="font-family: monospace; font-size: 12px;">{{ $item->product->sku ?? 'N/A' }}</td>
                        <td class="text-right">{{ env('CURRENCY_SIGN') . number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right font-medium">
                            {{ env('CURRENCY_SIGN') . number_format($item->subtotal, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #dc2626; padding: 20px;">
                            <strong>Warning: No items found for this record.</strong>
                        </td>
                    </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="4" class="text-right">Total Amount Due:</td>
                    <td class="text-right" style="color: #4f46e5;">
                        {{ env('CURRENCY_SIGN') . number_format($order->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p style="text-align: center; margin-top: 60px; font-size: 12px; color: #aaa;">
            Thank you for your business. For billing inquiries, please present this document identifier.
        </p>
    </div>
</body>

</html>
