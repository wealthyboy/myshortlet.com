<?php

namespace App\Jobs;

use App\Models\UserTracking;
use App\Notifications\AbandonedBookingNotification;
use App\Notifications\AbandonedCartAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class SendAbandonedBookingNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $threshold = Carbon::now()->subMinutes(1);

        $abandonedUsers = UserTracking::with('apartment')
            ->where('action', 'abandoned')
            ->whereNotNull('first_name')
            ->whereNotNull('last_name')
            ->whereNotNull('phone_number')
            ->whereNotNull('email')
            ->get();

        foreach ($abandonedUsers as $track) {
            Notification::route('mail', $track->email)
                ->notify(new AbandonedBookingNotification($track));


            Notification::route('mail', 'oluwa.tosin@avenuemontaigne.ng')
                ->notify(new AbandonedCartAlert($track));

            // Mark it as sent
            $track->update(['action' => 'sent']);
        }
    }
}
