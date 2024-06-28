<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [ "event_id", "user_id" ];

    // relation with event
    public function events()
    {
        return $this->belongsTo(Event::class);
    }

    // relation with users
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
