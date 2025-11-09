<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $invoice->invoice_number ?? 'INV-0001' }}</title>
    <style>
        @page {
            margin: 10px 10px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            background-color: rgb(248, 245, 244);
            position: relative;
        }

        .invoice-box {
            background-color: rgb(248, 245, 244);
            padding: 40px;
            border-radius: 8px;
        }

        /* HEADER */
        .header {
            width: 100%;
            margin-bottom: 30px;
        }

        .header td {
            vertical-align: top;
        }

        .logo-block {
            background-color: #342c27;
            width: 95px;
            height: 67px;
        }

        .logo-block img {
            height: 60px;
        }

        /* TABLES */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: middle;
        }

        .table thead {
            background-color: #342c27;
            color: #fff;
        }

        /* Center numeric columns */
        .table th:nth-child(2),
        .table th:nth-child(3),
        .table th:nth-child(4),
        .table td:nth-child(2),
        .table td:nth-child(3),
        .table td:nth-child(4) {
            text-align: center;
        }

        /* SUMMARY TABLE */
        .summary-table td {
            padding: 4px 0;
        }

        .summary-table tr:last-child td {
            border-top: 1px solid #000;
            font-weight: bold;
            font-size: 14px;
        }

        .terms {
            margin-top: 25px;
            font-size: 12.5px;
            line-height: 1.4;
            color: #333;
            font-weight: bolder;
        }

        .terms p {
            margin: 0 0 3px 0;
            padding: 0;
        }

        /* FOOTER */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11.5px;
            color: #000;
            border-top: 1px solid #ccc;
            padding: 8px 0;
            background-color: rgb(248, 245, 244);
        }
    </style>
</head>

<body>
    <div class="invoice-box">

        <!-- HEADER -->
        <table class="header">
            <tr>
                <td>
                    <div class="logo-block">
                        <img src="https://avenuemontaigne.ng/images/logo/avm_new.png" alt="Logo">
                    </div>
                </td>
                <td align="right">
                    <h4 style="margin-bottom: 0px;">Receipt #{{ $invoice->invoice ?? 'INV-0001' }}</h4>
                    <small>Date: {{ $invoice->created_at->format('D, M d, Y') }}</small>
                </td>
            </tr>
        </table>

        <!-- CLIENT & COMPANY INFO -->
        <table style="margin-bottom:20px;">
            <tr>
                <td width="50%">
                    <strong>Client</strong><br>
                    {{ $invoice->full_name }}<br>
                    {{ $invoice->address }}<br>
                    {{ $invoice->phone }}
                </td>
                <td width="50%" align="right">
                    <strong>Avenue Montaigne Limited</strong><br>
                    37 Cooper Road, Ikoyi, Lagos<br>
                    info@avenuemontaigne.ng<br>
                    +234 701 897 1322
                </td>
            </tr>
        </table>

        <!-- ITEMS -->
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th width="10%">Night(s)</th>
                    <th width="20%">Rate</th>
                    <th width="20%">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $subTotal = 0; @endphp
                @foreach($invoice->invoice_items as $item)
                @php
                $qty = floatval($item->quantity);
                $price = floatval($item->price);
                $total = $qty * $price;
                $subTotal += $total;
                $checkin = $item->checkin ? \Carbon\Carbon::parse($item->checkin)->format('D, M d, Y') : '';
                $checkout = $item->checkout ? \Carbon\Carbon::parse($item->checkout)->format('D, M d, Y') : '';
                $nights = $qty > 0 ? "{$qty} night" . ($qty > 1 ? 's' : '') : '';
                @endphp
                <tr>
                    <td>
                        Booking for {{ $item->name }} from {{ $checkin }} to {{ $checkout }} ({{ $nights }})
                    </td>
                    <td>{{ $qty }}</td>
                    <td>{{ $invoice->currency }}{{ number_format($price, 2) }}</td>
                    <td>{{ $invoice->currency }}{{ number_format($total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @php
        $discount = floatval($invoice->discount ?? 0);
        $cautionFee = floatval($invoice->caution_fee ?? 0);
        $grandTotal = $subTotal - $discount + $cautionFee;
        @endphp

        <!-- PAYMENT + SUMMARY SIDE BY SIDE -->
        <table style="width:100%; margin-top:25px;">
            <tr>
                <td width="55%" valign="top"></td>
                <td width="45%" valign="top" align="right">
                    <table class="summary-table" align="right" style="width:100%;">
                        <tr>
                            <td><b>Subtotal:</b></td>
                            <td align="right">{{ $invoice->currency }}{{ number_format($subTotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td><b>Discount:</b></td>
                            <td align="right">-{{ $invoice->currency }}{{ number_format($discount, 2) }}</td>
                        </tr>
                        <tr>
                            <td><b>Caution Fee:</b></td>
                            <td align="right">{{ $invoice->currency }}{{ number_format($cautionFee, 2) }}</td>
                        </tr>
                        <tr>
                            <td><b>Total:</b></td>
                            <td align="right"><b>{{ $invoice->currency }}{{ number_format($grandTotal, 2) }}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- TERMS -->
        <div class="terms">
            Check-in time is 2pm
            Check-out time is 12 noon
            Apartment is non-smoking; smoking in the apartment will result in forfeiture of the caution fee.
            Payment confirms reservation. 50% cancellation fee applies 48 hours after confirmation.
            Caution deposit will be refunded within 5 working days after checkout.
        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        <strong>&copy; {{ date('Y') }} Avenue Montaigne Limited. All Rights Reserved.</strong>
    </div>
</body>

</html>