<?php

namespace App\Http\Controllers\Event;

use App\Events\EventPosted;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;


class EventController extends Controller
{
    public function getAllEvents() {
        try {
            //code...
            $events = Event::all();
            return view("Events.events", [
                "events" => $events
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function createEventsForm() 
    {
        try {
            return view("Events.create");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createEvents( Request $request )
    {
        try {
            // dd(auth()->user()->name);
            $validatedData = $request->validate([
                "event_name" => "required|string",
                "title" => "required|string|min:5",
                "description" => "required|string",
                "start_time" => "required|date",
                "end_time" => "required|date|after_or_equal:start_time|after:+1 day",
            ]);
            // dd("asdasdas");
            $event = Event::create([
                "event_reminder_id" => "RE-" . Str::uuid(),
                "event_name" => $validatedData["event_name"],
                "title" => $validatedData["title"],
                "description" => $validatedData["description"],
                "start_time" => $validatedData["start_time"],
                "end_time" => $validatedData["end_time"],
                "user_id" => auth()->user()->id
            ]);
            
            // dispatching the events to everyone
            EventPosted::dispatch($event);

            return redirect()->route("events.index");

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getSingleEventDetails( $eventId )
    {
        try {
            $event = Event::findOrFail($eventId);
            return view("", [ "event" => $event ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateEventForm()
    {
        try {
            return view("");    
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function updateEvent(Request $request, $eventId)
    {
        try {
            $event = Event::findOrFail($eventId);
            $validatedData = $request->validate([
                "event_name" => "required|string",
                "title" => "required|string|min:5",
                "description" => "required|string|10",
                "start_time" => "required|date",
                "end_time" => "date"
            ]);
            $event->event_name = $validatedData["event_name"];
            $event->title = $validatedData["title"];
            $event->description = $validatedData["description"];
            $event->start_titme = $validatedData["start_time"];
            $event->end_time = $validatedData["date"];

            $event->save();

            return redirect("");
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
