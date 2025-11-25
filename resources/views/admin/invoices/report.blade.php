<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice Report</title>

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

        .report-box {
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
            vertical-align: middle;
        }

        .logo-block {
            background-color: #342c27;
            width: 95px;
            height: 67px;
        }

        .logo-block img {
            height: 60px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
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
        .table th:nth-child(3),
        .table th:nth-child(4),
        .table th:nth-child(5),
        .table td:nth-child(3),
        .table td:nth-child(4),
        .table td:nth-child(5) {
            text-align: center;
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
    <div class="report-box">

        <!-- HEADER -->
        <table class="header">
            <tr>
                <td>
                    <div class="logo-block">
                        <img src="https://avenuemontaigne.ng/images/logo/avm_new.png" alt="Logo">
                    </div>
                </td>
                <td align="right">
                    <h3 style="margin: 0;">Invoice Report</h3>
                    <small>Generated on: {{ now()->format('D, M d Y') }}</small><br>

                    @if(request('start_date') && request('end_date'))
                    <small>Range: {{ request('start_date') }} → {{ request('end_date') }}</small><br>
                    @endif

                    @if(request('status'))
                    <small>Status: {{ ucfirst(request('status')) }}</small>
                    @endif
                </td>
            </tr>
        </table>

        <!-- REPORT TABLE -->
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Amount</th> <!-- CHANGED -->
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice }}</td>
                    <td>{{ $invoice->full_name }}</td>

                    <td>
                        @if($invoice->sent)
                        <span style="color: green; font-weight: bold;">Paid</span>
                        @else
                        <span style="color: red;">Not Paid</span>
                        @endif
                    </td>

                    <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                    <td>{{ $invoice->currency ?? '₦' }}{{ number_format($invoice->total) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TOTAL AMOUNT BOX -->
        <div style="
            margin-top: 25px;
            padding: 12px 15px;
            text-align: right;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #fff;
            font-size: 15px;
            font-weight: bold;
        ">
            Total Amount:
            {{ $invoices->first()->currency ?? '₦' }}
            {{ number_format($invoices->sum('total'), 2) }}
        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        <strong>&copy; {{ date('Y') }} Avenue Montaigne Limited. All Rights Reserved.</strong>
    </div>

</body>

</html>