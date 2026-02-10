<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
</head>

<body style="font-family: Arial, sans-serif; color:#333;">
    <h3>Dear {{ $invoice->name }},</h3>
    <p>Thank you for your business. Please find attached your invoice:</p>

    <ul>
        <li><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</li>
        <li><strong>Total:</strong> {{ $invoice->currency }}{{ number_format($invoice->total, 2) }}</li>
    </ul>

    <p>If you have any questions, feel free to reach out to <a href="mailto:info@thecentralavenue.ng">info@thecentralavenue.ng</a>.</p>

    <p>Warm regards,<br><strong>Avenue Montaigne Limited</strong></p>
</body>

</html>