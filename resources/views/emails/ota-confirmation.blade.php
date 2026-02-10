@php
use Illuminate\Support\Str;

$guest = $reservation->guestUser ?? $reservation->guest_user;
$item = $reservation->reservations->first();

$checkin = optional($item)->checkin;
$checkout = optional($item)->checkout;

$start = optional($checkin)->format('Ymd');
$end = optional($checkout)->format('Ymd');

$calendarTitle = urlencode('Reservation at Avenue Montaigne');
$calendarDesc = urlencode('Your stay at Avenue Montaigne is confirmed.');
$calendarLocation = urlencode('Avenue Montaigne, Lagos');

$googleCalendarUrl = "https://www.google.com/calendar/render?action=TEMPLATE"
. "&text={$calendarTitle}"
. "&dates={$start}/{$end}"
. "&details={$calendarDesc}"
. "&location={$calendarLocation}";
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            padding: 24px;
            text-align: center;
        }

        .logo-light {
            display: block;
        }

        .logo-dark {
            display: none;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background: #0f0f0f;
            }

            .container {
                background: #1a1a1a;
                color: #ffffff;
            }

            .logo-light {
                display: none;
            }

            .logo-dark {
                display: block;
            }
        }

        .content {
            padding: 24px;
            font-size: 14px;
            color: #333;
        }

        @media (prefers-color-scheme: dark) {
            .content {
                color: #e5e5e5;
            }
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 4px;
            margin-bottom: 16px;
        }

        .badge-booking {
            background: #003580;
            color: #fff;
        }

        .badge-airbnb {
            background: #FF5A5F;
            color: #fff;
        }

        .badge-direct {
            background: #111;
            color: #fff;
        }

        .box {
            background: #f8f8f8;
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        @media (prefers-color-scheme: dark) {
            .box {
                background: #2a2a2a;
            }
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-right: 8px;
        }

        .btn-google {
            background: #4285F4;
            color: #fff;
        }

        .btn-apple {
            background: #000;
            color: #fff;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            padding: 16px;
            color: #777;
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:20px">

                <div class="container">

                    {{-- HEADER --}}
                    <div class="header">
                        <img src="https://avenuemontaigne.ng/logo-dark.png"
                            width="160"
                            class="logo-light"
                            alt="Avenue Montaigne">

                        <img src="https://avenuemontaigne.ng/logo-light.png"
                            width="160"
                            class="logo-dark"
                            alt="Avenue Montaigne">
                    </div>

                    {{-- CONTENT --}}
                    <div class="content">

                        {{-- OTA BADGE --}}
                        @if($reservation->ota_name)
                        @if(Str::contains(strtolower($reservation->ota_name), 'booking'))
                        <span class="badge badge-booking">Booking.com Reservation</span>
                        @elseif(Str::contains(strtolower($reservation->ota_name), 'airbnb'))
                        <span class="badge badge-airbnb">Airbnb Reservation</span>
                        @else
                        <span class="badge badge-direct">Direct Booking</span>
                        @endif
                        @else
                        <span class="badge badge-direct">Direct Booking</span>
                        @endif

                        <h2>Your reservation is confirmed 🎉</h2>

                        <p>
                            Hello {{ $guest->name ?? 'Guest' }},
                        </p>

                        <p>
                            Thank you for choosing <strong>Avenue Montaigne</strong>.
                            Your reservation has been successfully confirmed.
                        </p>

                        {{-- RESERVATION DETAILS --}}
                        <div class="box">
                            <strong>Reservation Details</strong><br><br>

                            <strong>Check-in:</strong> {{ optional($checkin)->format('D, d M Y') }}<br>
                            <strong>Check-out:</strong> {{ optional($checkout)->format('D, d M Y') }}<br>
                            <strong>Length of stay:</strong> {{ $reservation->length_of_stay }} night(s)<br>
                            <strong>Total:</strong> {{ $reservation->currency }}{{ number_format($reservation->total, 2) }}<br>
                            <strong>Invoice:</strong> {{ $reservation->invoice }}
                        </div>

                        {{-- APARTMENTS --}}
                        <div class="box">
                            <strong>Apartment(s)</strong><br><br>

                            @foreach($reservation->reservations as $room)
                            • {{ optional($room->apartment)->name }}<br>
                            @endforeach
                        </div>

                        {{-- CALENDAR --}}
                        <p><strong>Add to your calendar</strong></p>

                        <a href="{{ $googleCalendarUrl }}" class="btn btn-google" target="_blank">
                            📅 Google Calendar
                        </a>

                        <a href="{{ route('calendar.reservation', $reservation) }}" class="btn btn-apple">
                            🍎 Apple / Outlook
                        </a>

                        <p style="margin-top:24px">
                            If you have any questions or special requests, feel free to reply to this email.
                        </p>

                        <p>
                            We look forward to hosting you.<br>
                            <strong>Avenue Montaigne Team</strong>
                        </p>

                    </div>

                    {{-- FOOTER --}}
                    <div class="footer">
                        Avenue Montaigne · Lagos, Nigeria<br>
                        <a href="https://avenuemontaigne.ng">avenuemontaigne.ng</a>
                    </div>

                </div>

            </td>
        </tr>
    </table>
</body>

</html>