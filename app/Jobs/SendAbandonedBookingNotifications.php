<?php

namespace App\Jobs;

use App\Models\UserTracking;
use App\Notifications\AbandonedBookingNotification;
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
        // Define abandonment threshold (e.g., 30 minutes ago)
        $threshold = Carbon::now()->subMinutes(1);

        // Find user tracking records that indicate abandonment
        $abandonedUsers = UserTracking::where('action', 'abandoned')
            ->where('created_at', '<=', $threshold)
            ->get();

        foreach ($abandonedUsers as $track) {
            Notification::route('mail', $track->email)
                ->notify(new AbandonedBookingNotification($track));


            Notification::route('mail', 'Oluwa.tosin@avenuemontaigne.ng')
                ->notify(new AbandonedBookingNotification($track));

            // Mark it as sent
            $track->update(['action' => 'sent']);
        }
    }
}
