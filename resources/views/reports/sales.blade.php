<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            font-size: 13px;
            line-height: 20px;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border-top: 5px solid #10b981;
            border-radius: 4px;
            border: 1px solid #ddd;
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
            font-size: 32px;
            line-height: 38px;
            color: #111;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .invoice-header table td.company-details {
            text-align: right;
            font-size: 12px;
            color: #777;
        }

        .report-section {
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .order-row td {
            background: #f9fafb;
            font-weight: bold;
            color: #374151;
            padding: 12px;
            border-top: 2px solid #e5e7eb;
            border-bottom: 2px solid #e5e7eb;
            font-size: 14px;
        }

        .order-row .text-right {
            text-align: right;
        }

        .item-details {
            width: 95%;
            margin-left: 5%;
            margin-bottom: 15px;
            border-left: 2px solid #10b981;
        }

        .item-details th,
        .item-details td {
            padding: 6px 10px;
            border-bottom: 1px solid #f1f1f1;
            text-align: left;
            font-size: 12px;
        }

        .item-details th {
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        .item-details .text-right {
            text-align: right;
        }

        .grand-total td {
            font-size: 18px;
            font-weight: 800;
            color: #111;
            padding: 20px 10px;
            border-top: 3px solid #111;
            text-align: right;
        }

        .grand-total span {
            color: #10b981;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table class="invoice-header">
            <tr>
                <td class="title">PERIODIC<br>SALES REPORT</td>
                <td class="company-details">
                    <strong style="color: #333; font-size: 14px;">Smart Inventory System</strong><br>
                    Global Operations Center<br>
                    Generated on: {{ now()->format('M d, Y h:i A') }}
                </td>
            </tr>
        </table>

        <p style="margin-top: 20px; font-size: 14px;"><strong>Reporting Period:</strong>
            {{ \Carbon\Carbon::parse($from)->format('M d, Y') }} &mdash;
            {{ \Carbon\Carbon::parse($to)->format('M d, Y') }}</p>

        <section class="report-section">
            <table style="width: 100%;">
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @forelse($orders as $order)
                        @php $grandTotal += $order->total_amount; @endphp

                        <!-- Order Master Row -->
                        <tr class="order-row">
                            <td colspan="2">
                                <span style="color:#10b981;">&#9632;</span> Order {{ $order->reference_no }}
                                <span
                                    style="font-weight:normal; font-size:12px; color:#6b7280; margin-left:10px;">{{ $order->created_at->format('M d h:i A') }}
                                    - Cashier: {{ $order->user->name ?? 'System' }}</span>
                            </td>
                            <td class="text-right">Ord. Total:
                                {{ env('CURRENCY_SIGN') . number_format($order->total_amount, 2) }}</td>
                        </tr>

                        <!-- Order Items Sub-table -->
                        <tr>
                            <td colspan="3" style="padding: 0; border: none;">
                                <table class="item-details">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Product</th>
                                            <th style="width: 20%;">SKU</th>
                                            <th class="text-right">Price</th>
                                            <th class="text-right">Qty</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->items as $item)
                                            <tr>
                                                <td style="font-weight: 500;">{{ $item->product->name ?? 'N/A' }}</td>
                                                <td style="font-family: monospace;">{{ $item->product->sku ?? '-' }}
                                                </td>
                                                <td class="text-right">
                                                    {{ env('CURRENCY_SIGN') . number_format($item->unit_price, 2) }}
                                                </td>
                                                <td class="text-right">{{ $item->quantity }}</td>
                                                <td class="text-right">
                                                    {{ env('CURRENCY_SIGN') . number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" style="color:red; text-align:center;">No specific
                                                    items tracked.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="3"
                                style="text-align:center; padding: 40px; color: #dc2626; font-size: 16px;">
                                <strong>No completed sales found in this period.</strong>
                            </td>
                        </tr>
                    @endforelse

                    <tr class="grand-total">
                        <td colspan="2">Net Revenue (Period):</td>
                        <td><span>{{ env('CURRENCY_SIGN') . number_format($grandTotal, 2) }}</span></td>
                    </tr>
                </tbody>
            </table>
        </section>

    </div>
</body>

</html>
