<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice }}</title>
</head>

<body style="font-family: Arial, sans-serif; color:#333; line-height:1.6; background-color:#f9f9f9; padding:20px;">
    @php
        $paystackPaymentUrl = URL::temporarySignedRoute(
            'invoices.paystack.pay',
            now()->addDays(30),
            ['invoice' => $invoice->id]
        );
    @endphp
    <div style="max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.05);">

        <h3 style="color:#444;">Dear {{ $invoice->full_name }},</h3>

        <p>
            Thank you for choosing <strong>Avenue Montaigne</strong> for your stay.
            Further to your enquiry, and in accordance with your request,
            please find attached the invoice for your reservation.
        </p>

        <ul style="list-style:none; padding:0;">
            <li><strong>Invoice Number:</strong> {{ $invoice->invoice }}</li>
        </ul>

        <p>
            Kindly note that your reservation will be confirmed upon receipt of payment.
        </p>

        <p style="margin:24px 0; text-align:center;">
            <a href="{{ $paystackPaymentUrl }}" style="display:inline-block; padding:13px 22px; border-radius:6px; color:#fff; background:#342c27; text-decoration:none; font-weight:bold;">
                Click here to pay with Paystack
            </a>
        </p>
        <p style="font-size:13px; color:#666; text-align:center;">Pay {{ $invoice->currency }}{{ number_format($invoice->total, 2) }} securely in the invoice currency.</p>

        <p>
            If you have any questions, please do not hesitate to contact us at
            <a href="mailto:info@avenuemontaigne.ng" style="color:#007bff; text-decoration:none;">info@avenuemontaigne.ng</a>
        </p>

        <p style="margin-top:30px;">
            Warm regards,<br>
            <strong>Avenue Montaigne Limited</strong>
        </p>

    </div>
</body>

</html>
