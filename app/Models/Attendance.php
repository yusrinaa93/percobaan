<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // allow mass assignment for user_id and schedule_id
    protected $fillable = [
        'user_id',
        'schedule_id',
    ];
}
