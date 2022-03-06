<?php

namespace App\Models\Invoice;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskUser extends Model
{
    use SoftDeletes;

    protected $table = 'task_users';

    protected $fillable = [
        'task_id',
        'user_id'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tasks() {
        return $this->belongsTo(Task::class, 'task_id', 'id')->with('taskUsers');
    }

   
}
