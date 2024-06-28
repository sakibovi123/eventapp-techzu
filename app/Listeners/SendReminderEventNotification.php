<?php

namespace App\Listeners;

use App\Events\ReminderEvents;
use App\Mail\ReminderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Mail;


class SendReminderEventNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReminderEvents $event): void
    {
        $followers = Follow::where("event_id", $event->event->id)
            ->pluck("user_id");

        $users = User::whereIn("id", $followers)->get();
        foreach( $users as $user )
        {
            Mail::to($user->email)->later(now()->addSeconds(2), new ReminderNotification($event->event));
                
        }
    }
}
