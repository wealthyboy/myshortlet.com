<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay invoice {{ $invoice->invoice }} | Avenue Montaigne</title>
    <style>
        body { margin:0; min-height:100vh; display:grid; place-items:center; padding:24px; box-sizing:border-box; background:#f8f5f4; color:#342c27; font-family:Arial,sans-serif; }
        .card { width:100%; max-width:520px; box-sizing:border-box; padding:38px; background:#fff; border-radius:14px; box-shadow:0 14px 38px rgba(52,44,39,.13); text-align:center; }
        .brand { font-size:13px; letter-spacing:.12em; font-weight:700; color:#766960; }
        h1 { margin:12px 0 8px; font-size:28px; }
        .detail { color:#665d57; margin:0 0 24px; line-height:1.55; }
        .amount { margin:24px 0; padding:20px; border-radius:9px; background:#f8f5f4; font-size:26px; font-weight:700; }
        button { width:100%; border:0; border-radius:8px; padding:16px; background:#342c27; color:#fff; font-size:16px; font-weight:700; cursor:pointer; }
        button:disabled { opacity:.55; cursor:not-allowed; }
        .note { margin-top:18px; color:#766960; font-size:13px; line-height:1.5; }
        .success { color:#237b4b; font-weight:700; }
    </style>
</head>
<body>
    <main class="card">
        <div class="brand">AVENUE MONTAIGNE</div>
        <h1>Invoice {{ $invoice->invoice }}</h1>
        <p class="detail">Hello {{ $invoice->full_name }}, review your invoice amount and pay securely with Paystack.</p>
        <div class="amount">{{ $invoice->currency }}{{ number_format($invoice->total, 2) }}</div>

        @if($alreadyPaid)
            <p class="success">This invoice has already been marked as paid. Thank you.</p>
        @elseif($paymentSubmitted)
            <p class="success">Your card payment was received and is being confirmed. We will email your reservation confirmation shortly.</p>
        @elseif(empty($paystackPublicKey))
            <p class="detail">Online payment is temporarily unavailable. Please contact us for payment details.</p>
        @else
            <button id="paystack-button" type="button">Click here to pay with card</button>
            <p class="note">You will be taken to Paystack's secure payment window. The amount and currency above are fixed from this invoice.</p>
        @endif
    </main>

    @if(! $alreadyPaid && ! empty($paystackPublicKey))
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script>
            document.getElementById('paystack-button').addEventListener('click', function () {
                var button = this;
                button.disabled = true;
                var handler = PaystackPop.setup({
                    key: @json($paystackPublicKey),
                    email: @json($invoice->email ?: 'payments@avenuemontaigne.ng'),
                    amount: {{ $amountInMinor }},
                    currency: @json($currency),
                    reference: 'invoice-{{ $invoice->id }}-' + Date.now(),
                    metadata: {
                        invoice_payment: true,
                        invoice_id: {{ $invoice->id }},
                        invoice_number: @json($invoice->invoice)
                    },
                    callback: function () {
                        button.textContent = 'Payment received. Confirming…';
                        window.location.href = @json($confirmationUrl);
                    },
                    onClose: function () { button.disabled = false; }
                });
                handler.openIframe();
            });
        </script>
    @endif
</body>
</html>
