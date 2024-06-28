<?php

namespace App\Http\Controllers\Follow;

use App\Events\EventPosted;
use App\Events\ReminderEvents;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class FollowController extends Controller
{
    public function follow( $eventId )
    {
        $event = Event::where("id", $eventId)->first();

        if( $event )
        {
            $follow = Follow::create([
                "event_id" => $event->id,
                "user_id" => auth()->user()->id
            ]);

            //dispatching
            // Queue::later(now()->addSeconds(2), new ReminderEvents($event));
            ReminderEvents::dispatch($event);


        }

        return redirect()->route("events.index");
    }

    public function unfollow( $eventId )
    {
        $event = Event::where("id", $eventId)->first();
        // dd($event)->event_name;
        if( $event )
        {
            $follow = Follow::where("event_id", $event->id)->where("user_id", auth()->user()->id)->first();
            // dd($follow);
            if( $follow ) {
                $follow->delete();
            }
            
        }
        return redirect()->route("events.index");
    }
}
