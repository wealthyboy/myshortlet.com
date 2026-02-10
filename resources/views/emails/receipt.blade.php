<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Receipt {{ $invoice->invoice }}</title>
</head>

<body style="font-family: Arial, sans-serif; color:#333;">
    <h3>Dear {{ $invoice->full_name }},</h3>
    <p>
        Thank you for choosing Avenue montaigne for your stay. Please find attached your receipt:</p>

    <b>Note: You’re required to present a valid ID upon arrival to check-in. You can also self check-in by clicking the link below to upload your ID
        <br />
        <a style="text-align:left; font-family: 'Montserrat', Arial, Helvetica, sans-serif; font-size:14px; line-height: 14px; text-decoration: none; color: #27af9a; font-weight:600; text-transform: uppercase; letter-spacing: 0.05em" class="" href="https://avenuemontaigne.ng/check-in?id={{$user_reservation->id}}">Click here to Check-in</a>
    </b>



    <p>If you have any questions, feel free to reach out to <a href="mailto:info@thecentralavenue.ng">info@thecentralavenue.ng</a>.</p>

    <p>Warm regards,<br><strong>Avenue Montaigne Limited</strong></p>
</body>

</html>