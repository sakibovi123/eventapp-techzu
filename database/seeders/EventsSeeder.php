<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'event_reminder_id' => "RE-" . Str::uuid()->toString(),
                'event_name' => 'Meeting with client',
                'title' => 'Project Discussion',
                'description' => 'Discuss the requirements and deliverables for the new project.',
                'start_time' => '2024-07-01',
                'end_time' => '2024-07-02',
                'status' => "Upcoming",
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => '1'
            ],
            [
                'event_reminder_id' => "RE-" . Str::uuid()->toString(),
                'event_name' => 'Team Standup',
                'title' => 'Daily Standup Meeting',
                'description' => 'Daily standup meeting with the development team.',
                'start_time' => '2024-07-02',
                'end_time' => '2024-07-03',
                'status' => "Upcoming",
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => '1'
            ],
            // Add more events as needed
        ]);
    }
}
