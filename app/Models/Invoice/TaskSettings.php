<?php

namespace App\Models\Invoice;

use App\Models\Invoice\Task;
use App\Models\User;
use App\Models\Invoice\TasksHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskSettings extends Model
{
    use SoftDeletes;

    protected $table = 'task_settings';

    protected $fillable = [
        'task_id',
        'setting_id',
        'user_id',
        'setting' => 'array',
        'created_at'
    ];

    public function settings() {
        return $this->belongsTo(TasksHelper::class, 'setting_id', 'id');
    }

    public function tasks() {
        return $this->belongsTo(Task::class, 'task_id', 'id')->with('taskUsers');
    }
    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
