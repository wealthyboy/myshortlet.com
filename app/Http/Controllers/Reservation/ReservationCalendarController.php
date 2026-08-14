<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\UserReservation;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ReservationCalendarController extends Controller
{
    public function __invoke(UserReservation $reservation): Response
    {
        $stay = $reservation->reservations()->with('apartment')->firstOrFail();
        $checkin = Carbon::parse($stay->checkin);
        $checkout = Carbon::parse($stay->checkout);
        $propertyName = optional($reservation->property)->name ?: 'Avenue Montaigne';
        $apartmentName = optional($stay->apartment)->name;
        $summary = 'Stay at ' . $propertyName;
        $description = $apartmentName
            ? 'Confirmed reservation for ' . $apartmentName
            : 'Your confirmed reservation';

        $escape = static function (?string $value): string {
            return str_replace(
                ["\\", ";", ",", "\r\n", "\r", "\n"],
                ["\\\\", "\\;", "\\,", "\\n", "\\n", "\\n"],
                (string) $value
            );
        };

        $ical = implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Avenue Montaigne//Reservation Calendar//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:reservation-' . $reservation->id . '@avenuemontaigne.ng',
            'DTSTAMP:' . now('UTC')->format('Ymd\THis\Z'),
            'DTSTART;VALUE=DATE:' . $checkin->format('Ymd'),
            'DTEND;VALUE=DATE:' . $checkout->format('Ymd'),
            'SUMMARY:' . $escape($summary),
            'DESCRIPTION:' . $escape($description),
            'LOCATION:' . $escape($propertyName . ', Lagos'),
            'STATUS:CONFIRMED',
            'END:VEVENT',
            'END:VCALENDAR',
            '',
        ]);

        return response($ical, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="avenue-montaigne-reservation-' . $reservation->id . '.ics"',
            'Cache-Control' => 'private, no-store, max-age=0',
        ]);
    }
}
