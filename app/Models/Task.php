<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'assign_by_id',
        'user_id',
        'name',
        'short_description',
        'description',
        'note',
        'link',
        'minutes',
        'date',
        'time_start',
        'time_end',
        'submit_at',
        'status',
    ];
    
}
