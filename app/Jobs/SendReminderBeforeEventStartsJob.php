<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\Follow;
use App\Models\User;
use App\Notifications\SendReminderBeforeStartingEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReminderBeforeEventStartsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    /**
     * Create a new job instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $followers = Follow::where("event_id", $this->event->id)
            ->pluck("user_id");

        $users = User::whereIn("id", $followers)->get();

        foreach( $users as $user )
        {
            $user->notify( new SendReminderBeforeStartingEvent( $this->event ) );
        }
    }
}
