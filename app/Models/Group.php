<?php

namespace App\Models;
use App\Models\Task;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
