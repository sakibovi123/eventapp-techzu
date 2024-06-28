<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Event extends Model
{
    use HasFactory;

    protected $fillable = ['event_name', 'title', 'description', 'start_time', 'end_time', 'status', 'user_id', 'event_reminder_id'];

    protected $casts = [
        "start_time" => "date",
        "end_time" => "date"
    ];

    // relation for user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relation for followers
    public function followers()
    {
        return $this->hasMany(Follow::class);
    }
}
