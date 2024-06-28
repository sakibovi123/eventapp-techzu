<?php

namespace App\Listeners;

use App\Events\EventPosted;
use App\Mail\EventPostedNotification;
use App\Models\Follow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEventPostedNotification
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
    public function handle(EventPosted $event): void
    {
        
        // $followers = Follow::where("event_id", $event->event->id)
        //     ->pluck("user_id");

        // $users = User::whereIn("id", $followers)->get();

        $users = User::all();
        // dd($users);
        foreach( $users as $user ) {
            Mail::to($user->email)
                ->send(new EventPostedNotification($event->event));
        }
    }
}
