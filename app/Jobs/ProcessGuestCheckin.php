<?php

namespace App\Jobs;

use App\Models\Attribute;
use App\Models\Guest;
use App\Models\GuestUser;
use App\Models\Reservation;
use App\Notifications\AgentCheckingNotification;
use App\Notifications\CheckinNotification;
use App\Notifications\NewGuest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;


class ProcessGuestCheckin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $guest;
    protected $reservation;
    protected $attribute;


    public function __construct(GuestUser $guest, Reservation $reservation, Attribute $attribute)
    {
        $this->guest = $guest;
        $this->reservation = $reservation;
        $this->attribute = $attribute;
    }

    public function handle()
    {
        $directory = public_path('pdf');
        $fileName = 'guest_' . $this->guest->name . '_' . $this->guest->id . '.pdf';

        // Check if the directory exists, if not create it
        if (!File::exists($directory)) {
            File::makeDirectory($directory);
        }


        $reservation = $this->reservation;

        $attribute = $this->attribute;

        $g = $this->guest;

        // Save the file to the specified directory
        $pdf = PDF::loadView('pdf.index', compact('g', 'reservation', 'attribute'));
        $pdf->setPaper('a4')->save($directory . '/' . $fileName);

        try {
            // $this->guest->notify(new NewGuest($this->guest));
            // $this->guest->notify(new CheckinNotification($this->guest));

            Notification::route('mail', $this->guest->email)
                ->notify(new  NewGuest($this->guest));
            Notification::route('mail', 'avenuemontaigneconcierge@gmail.com')
                ->notify(new CheckinNotification($this->guest, $this->attribute));


            // Notification::route('mail', $this->attribute->apartment_owner)
            //     ->notify(new AgentCheckingNotification($this->guest, $this->attribute, $this->reservation));
        } catch (\Throwable $th) {
            // Log error if needed
            \Log::error("Mail error: " . $th);
        }
    }
}
