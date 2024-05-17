<?php

namespace App\Jobs;

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

class ProcessGuestCheckin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $guest;
    protected $reservation;
    protected $visitor;


    public function __construct(GuestUser $guest, Reservation $reservation)
    {
        $this->guest = $guest;
        $this->reservation = $reservation;
        $this->visitor = null;
    }

    public function handle()
    {
        $directory = public_path('pdf');
        $fileName = 'guest_' . $this->guest->name . '_' . $this->guest->id . '.pdf';

        // Check if the directory exists, if not create it
        if (!File::exists($directory)) {
            File::makeDirectory($directory);
        }

        $visitor = $this->visitor;

        $reservation = $this->reservation;

        // Save the file to the specified directory
        $pdf = PDF::loadView('pdf.index', compact('reservation'));
        $pdf->setPaper('a4')->save($directory . '/' . $fileName);

        try {
            $this->guest->notify(new NewGuest($this->guest));
            $this->guest->notify(new CheckinNotification($this->guest));

            if ($this->guest->apartment_owner) {
                $this->guest->apartment_name = $this->reservation->name;
                $this->guest->checkin = $this->reservation->start_date;
                $this->guest->checkout = $this->reservation->end_date;
                $this->guest->notify(new AgentCheckingNotification($this->guest));
            }
        } catch (\Throwable $th) {
            // Log error if needed
            // Log::error("Mail error: " . $th);
        }
    }
}
