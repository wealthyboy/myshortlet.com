<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice Preview</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: rgb(248, 245, 244);
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        .bg-dark {
            background-color: #342c27 !important;
        }

        .invoice-box {
            background: #fff;
            padding: 40px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
            margin: 40px auto;
            max-width: 950px;
        }

        .invoice-header img {
            height: 70px;
        }

        .invoice-header h5 {
            font-weight: bold;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
        }

        .summary {
            text-align: right;
        }

        .summary td {
            width: 50%;
        }

        .payment-details {
            font-size: 0.95rem;
        }

        .terms {
            font-size: 0.9rem;
            white-space: pre-line;
        }

        @media (max-width: 767.98px) {
            .invoice-box {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 invoice-header">
            <a class="inline-block bg-dark" href="https://avenuemontaigne.ng/admin/invoices">
                <img src="https://drive.google.com/thumbnail?id=1eQ_hLe9Th_2Oew3Qoew_qQKhuGBpHGZm&sz=w2000" alt="Logo">
            </a>
            <div class="text-right">
                <h5>
                    Invoice #{{ $data['invoice_number'] ?? 'INV-' . str_pad($data['id'] ?? 1, 4, '0', STR_PAD_LEFT) }}
                </h5>
                @php
                $invoiceDate = isset($data['date']) && !empty($data['date'])
                ? \Carbon\Carbon::parse($data['date'])
                : \Carbon\Carbon::now();
                @endphp
                <small>Date: {{ $invoiceDate->format('D, M d, Y') }}</small>
            </div>
        </div>

        <!-- Client & Supplier -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="font-weight-bold">Client</h6>
                <p class="mb-1">{{ $data['name'] ?? '' }}</p>
                <p class="mb-1">{{ $data['address'] ?? '' }}</p>
                <p class="mb-1">{{ $data['email'] ?? '' }}</p>
                <p class="mb-1">{{ $data['phone'] ?? '' }}</p>
            </div>
            <div class="col-md-6 text-md-right">
                <h6 class="font-weight-bold">Avenue Montaigne Limited</h6>
                <p class="mb-1">37 Cooper Road, Ikoyi, Lagos</p>
                <p class="mb-1">info@thecentralavenue.ng</p>
                <p class="mb-1">+234 701 897 1322</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-dark bg-dark text-white">
                    <tr>
                        <th>Description</th>
                        <th width="10%">Night(s)</th>
                        <th width="20%">Rate</th>
                        <th width="20%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    use Carbon\Carbon;
                    $subTotal = 0;
                    @endphp

                    @foreach($data['items'] ?? [] as $item)
                    @php
                    $qty = floatval($item['qty'] ?? 0);
                    $price = floatval($item['price'] ?? 0);
                    $total = $qty * $price;
                    $subTotal += $total;

                    $name = trim($item['name'] ?? '');
                    $apartment = $item['apartment_name'] ?? $name;
                    $checkin = $item['checkin'] ?? null;
                    $checkout = $item['checkout'] ?? null;

                    // Format raw YYYY-MM-DD dates in name → readable
                    $formattedName = preg_replace_callback(
                    '/\d{4}-\d{2}-\d{2}/',
                    function ($matches) {
                    return Carbon::parse($matches[0])->format('D, M d, Y');
                    },
                    $name
                    );

                    // Avoid double "Booking for"
                    if (stripos($formattedName, 'booking for') !== false) {
                    $description = ucfirst($formattedName);
                    } else {
                    $description = $apartment ? "Booking for {$apartment}" : "Booking";

                    if ($checkin && $checkout) {
                    $description .= " from " . Carbon::parse($checkin)->format('l, F d, Y') .
                    " to " . Carbon::parse($checkout)->format('l, F d, Y');
                    }
                    }

                    if ($qty > 0) {
                    $description .= " ({$qty} night" . ($qty > 1 ? 's' : '') . ")";
                    }
                    @endphp

                    <tr>
                        <td>{{ $description }}</td>
                        <td>{{ $qty }}</td>
                        <td>{{ $data['currency'] ?? '' }}{{ number_format($price, 2) }}</td>
                        <td>{{ $data['currency'] ?? '' }}{{ number_format($total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @php
        $discount = floatval($data['discount'] ?? 0);
        $discountType = $data['discount_type'] ?? 'fixed';
        $cautionFee = floatval($data['caution_fee'] ?? 0);
        $discountValue = $discountType === 'percent' ? ($subTotal * $discount / 100) : $discount;
        $grandTotal = $subTotal - $discountValue + $cautionFee;
        @endphp

        <!-- Payment + Summary -->
        <div class="row mt-4">
            <!-- Payment Details -->
            <div class="col-md-6">
                <h6 class="font-weight-bold mb-2">Payment Details</h6>
                <div class="payment-details">
                    {!! nl2br(e($data['payment_info'] ?? 'Please make payment using the following details:
                    Avenue Montaigne Limited
                    Providus Bank
                    1305006894')) !!}
                </div>
            </div>

            <!-- Summary -->
            <div class="col-md-6 summary">


                <td valign="top" align="right">
                    <table class="summary-table" align="right" style="width:100%;">
                        <tr>
                            <td><b>Subtotal:</b></td>
                            <td align="right">{{ $invoice->currency }}{{ number_format($subTotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td><b>Discount:</b></td>
                            <td align="right">-{{ $invoice->currency }}{{ $invoice->discount }}</td>
                        </tr>
                        <tr>
                            <td><b>Caution Fee:</b></td>
                            <td align="right">{{ $invoice->currency }}{{ number_format($invoice->caution_fee, 2) }}</td>
                        </tr>
                        <tr>
                            <td><b>Total:</b></td>
                            <td align="right"><b>{{ $invoice->currency }}{{ number_format($invoice->total, 2) }}</b></td>
                        </tr>
                    </table>
                </td>
            </div>
        </div>

        <!-- Terms / Notes -->
        <div class="mt-4 terms">
            <p>{{ $data['description'] ?? '' }}</p>
        </div>
    </div>
</body>

</html>