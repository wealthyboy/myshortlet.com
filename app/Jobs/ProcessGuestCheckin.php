<?php

namespace App\Jobs;

use App\Models\Apartment;
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

    public $timeout = 300;  // Adjust as needed
    public $tries = 5;      // Adjust as needed


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $guest;
    protected $reservation;
    protected $apartment;


    public function __construct(GuestUser $guest, Reservation $reservation, Apartment $apartment)
    {
        $this->guest = $guest;
        $this->reservation = $reservation;
        $this->apartment = $apartment;
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
        $apartment = $this->apartment;
        $g = $this->guest;

        // Save the file to the specified directory
        $pdf = PDF::loadView('pdf.index', compact('g', 'reservation', 'apartment'));
        $pdf->setPaper('a4')->save($directory . '/' . $fileName);

        try {

            Notification::route('mail', $this->guest->email)
                ->notify(new  NewGuest($this->guest));

            Notification::route('mail', 'frontdesk@avenuemontaigne.ng')
                ->notify(new CheckinNotification($this->guest, $this->apartment));

            Notification::route('mail', $this->apartment->owner_email)
                ->notify(new AgentCheckingNotification($this->guest, $this->apartment, $this->reservation));
        } catch (\Throwable $th) {
            // Log error if needed
            \Log::error("Mail error: " . $th);
        }
    }
}
