<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Karossy booking receipt</title>
</head>
<body style="margin:0;padding:0;background:#f3f5f8;font-family:Arial,Helvetica,sans-serif;color:#172033;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f3f5f8;">
    <tr>
        <td align="center" style="padding:28px 12px;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:660px;background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 10px 30px rgba(16,42,86,.10);">
                <tr>
                    <td style="padding:26px 34px;background:#ffffff;border-bottom:1px solid #e7eaf0;">
                        <img src="{{ $message->embed(public_path('karossy-email-logo.png')) }}" alt="Karossy Travels and Tours Limited" width="260" style="display:block;width:260px;max-width:80%;height:auto;border:0;">
                    </td>
                </tr>
                <tr>
                    <td style="padding:34px;background:#102a56;color:#ffffff;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td>
                                    <div style="font-size:12px;font-weight:700;letter-spacing:1.8px;color:#ffb9bc;">BOOKING CONFIRMED</div>
                                    <h1 style="margin:10px 0 6px;font-size:30px;line-height:38px;color:#ffffff;">Your journey is booked.</h1>
                                    <p style="margin:0;font-size:15px;line-height:24px;color:#dce5f3;">Hello {{ $booking['name'] }}, your Karossy Travels demo booking has been confirmed.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px 34px;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#fff2f3;border:1px solid #ffdadd;border-radius:14px;">
                            <tr>
                                <td style="padding:18px 20px;">
                                    <div style="font-size:11px;font-weight:700;letter-spacing:1.3px;color:#d71920;">BOOKING REFERENCE</div>
                                    <div style="margin-top:6px;font-size:25px;font-weight:800;letter-spacing:1.5px;color:#102a56;">{{ $reference }}</div>
                                </td>
                                <td align="right" style="padding:18px 20px;">
                                    <span style="display:inline-block;padding:8px 12px;border-radius:20px;background:#e4f6ec;color:#16784c;font-size:12px;font-weight:700;">PAID</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 34px 24px;">
                        <h2 style="margin:0 0 16px;font-size:20px;color:#102a56;">Flight itinerary</h2>
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #e0e5ec;border-radius:14px;">
                            <tr>
                                <td style="padding:20px;border-bottom:1px solid #e7eaf0;">
                                    <div style="font-size:12px;color:#697386;">AIRLINE</div>
                                    <div style="margin-top:5px;font-size:18px;font-weight:700;color:#172033;">{{ $booking['airline'] }}{{ $airlineCode }}</div>
                                </td>
                                <td align="right" style="padding:20px;border-bottom:1px solid #e7eaf0;">
                                    <div style="font-size:12px;color:#697386;">ROUTE</div>
                                    <div style="margin-top:5px;font-size:18px;font-weight:800;color:#102a56;">{{ $booking['route'] }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:20px;border-bottom:1px solid #e7eaf0;">
                                    <div style="font-size:12px;color:#697386;">TRAVEL DATES</div>
                                    <div style="margin-top:5px;font-size:16px;font-weight:700;">{{ $booking['departure_date'] }} &rarr; {{ $booking['return_date'] }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:20px;">
                                    <div style="font-size:12px;color:#697386;">DEPARTURE</div>
                                    <div style="margin-top:5px;font-size:20px;font-weight:800;color:#102a56;">{{ $booking['departure_time'] ?: 'To be confirmed' }}</div>
                                    <div style="margin-top:5px;font-size:12px;color:#697386;">{{ $booking['duration'] }} &middot; {{ $booking['stops'] }}</div>
                                </td>
                                <td align="right" style="padding:20px;">
                                    <div style="font-size:12px;color:#697386;">ARRIVAL</div>
                                    <div style="margin-top:5px;font-size:20px;font-weight:800;color:#102a56;">{{ $booking['arrival_time'] ?: 'To be confirmed' }}</div>
                                    <div style="margin-top:5px;font-size:12px;color:#697386;">{{ $booking['cabin_class'] }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 34px 24px;">
                        <h2 style="margin:0 0 16px;font-size:20px;color:#102a56;">Traveler and payment</h2>
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;">
                            @foreach ([
                                'Traveler' => $booking['name'],
                                'Travelers' => $booking['travelers'],
                                'Email' => $booking['email'],
                                'Phone' => $booking['phone'],
                                'Passport country' => $booking['passport_country'],
                                'Billing city' => $booking['billing_city'],
                                'Payment method' => $booking['payment_method'],
                                'Flight protection' => $protection,
                            ] as $label => $value)
                                <tr>
                                    <td style="padding:11px 0;border-bottom:1px solid #edf0f4;font-size:13px;color:#697386;">{{ $label }}</td>
                                    <td align="right" style="padding:11px 0;border-bottom:1px solid #edf0f4;font-size:13px;font-weight:700;color:#172033;">{{ $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 34px 28px;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#102a56;border-radius:14px;">
                            <tr>
                                <td style="padding:22px;color:#ffffff;">
                                    <div style="font-size:12px;color:#c9d6e8;">TOTAL PAID</div>
                                    <div style="margin-top:5px;font-size:28px;font-weight:800;">{{ $amount }}</div>
                                </td>
                                <td align="right" style="padding:22px;color:#ffffff;">
                                    <div style="font-size:12px;color:#c9d6e8;">STATUS</div>
                                    <div style="margin-top:5px;font-size:15px;font-weight:700;">Payment approved</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px 34px;background:#f8f9fb;border-top:1px solid #e7eaf0;">
                        <p style="margin:0;font-size:13px;line-height:21px;color:#697386;">Keep this receipt for your records. For assistance, contact <a href="mailto:info@karrosey.com" style="color:#d71920;font-weight:700;text-decoration:none;">info@karrosey.com</a> or call <a href="tel:+2340761382134" style="color:#d71920;font-weight:700;text-decoration:none;">+2340761382134</a>.</p>
                        <p style="margin:14px 0 0;font-size:12px;color:#98a0ad;">Karossy Travels and Tours Limited &middot; Your journey, beautifully planned.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
