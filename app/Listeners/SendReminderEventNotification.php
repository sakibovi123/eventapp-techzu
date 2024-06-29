<?php

namespace App\Listeners;

use App\Events\ReminderEvents;
use App\Mail\ReminderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;


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
            // notification sending time -> It will send email before 10 min of ending event
            $notification_time = Carbon::parse($event->event->end_time)->subMinutes(10);
            Mail::to($user->email)->later($notification_time, new ReminderNotification($event->event));

        }
    }
}
