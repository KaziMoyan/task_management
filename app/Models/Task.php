<?php 

namespace App\Models;

use App\Models\Group;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'assign_by_id',
        'user_id',
        'group_id', // ✅ added group_id
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group() // ✅ added group relationship
    {
        return $this->belongsTo(Group::class);
    }
}
