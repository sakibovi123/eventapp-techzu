<?php

namespace App\Imports;

use App\Models\Event;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventImport implements ToModel, WithHeadingRow
{

    public function model( array $row ) {
        return new Event([
            'event_reminder_id' => (string) Str::uuid(),
            'event_name' => $row['event_name'],
            'title' => $row['title'],
            'description' => $row['description'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'user_id' => $row['user_id'],
            'status' => $row['status']
        ]);
    }
}
