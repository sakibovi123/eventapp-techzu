<?php

namespace App\Http\Controllers\Event;

use App\Events\EventPosted;
use App\Http\Controllers\Controller;
use App\Imports\EventImport;
use App\Jobs\SendReminderBeforeEventStartsJob;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

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
            // dd($request);
            $validatedData = $request->validate([
                "event_name" => "required|string",
                "title" => "required|string|min:5",
                "description" => "required|string",
                'start_time' => 'required|date_format:Y-m-d\TH:i',
                'end_time' => 'required|date_format:Y-m-d\TH:i',
            ]);

            $validatedData["start_time"] = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData["start_time"]);
            $validatedData["end_time"] = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData["end_time"]);

            // dd($validatedData["start_time"]);
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

            // settings status
            $start_time = Carbon::parse($event->start_time);

            $event->status = $start_time->isToday() ? 'Ongoing' : 'Upcoming';

            $event->save();

            // dispatching the events to everyone
            EventPosted::dispatch($event);

            // dispatching the reminder when the event is about to start => 1 hour before
            $one_hour_before = $start_time->copy()->subHour();
            $delay = Carbon::now()->diffInSeconds($one_hour_before, false);
            // dd($delay);

            if( $delay < 0 )
            {
                $delay = 0;
            }

            SendReminderBeforeEventStartsJob::dispatch($event)->delay(now()->addSeconds($delay));

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

    public function updateEventForm($eventId)
    {
        try {
            $event = Event::findOrFail($eventId);
            return view("Events.update", [ "event" => $event ]);
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
                "description" => "required|string",
                'start_time' => 'required|date_format:Y-m-d\TH:i',
                'end_time' => 'required|date_format:Y-m-d\TH:i',
            ]);

            $event->event_name = $validatedData["event_name"];
            $event->title = $validatedData["title"];
            $event->description = $validatedData["description"];
            $event->start_time = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData["start_time"]);
            $event->end_time = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData["end_time"]);

            $event->save();

            return redirect()->route("events.index");

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteEvent( $eventId ) {
        $event = Event::findOrFail($eventId);

        if( $event )
        {
            $event->delete();
            return redirect()->route("events.index")->with('success', "Event removed");
        }

        return redirect()->route('events.index')->with('error', 'Event not found');
    }

    // import event data from CSV

    public function importCsv( Request $request ) {
        $request->validate([
            "csv_file" => "required|mimes:csv|max:2048"
        ]);
        // dd($request);

        $csv_file = $request->file('csv_file')->getRealPath();
        // dd($csv_file);
        try {
            Excel::import(new EventImport, $csv_file);

            return redirect()->route("events.index");
        } catch( \Exception $e ) {
            return redirect()->back()->with('error', 'Error importing data');
        }
    }
}
