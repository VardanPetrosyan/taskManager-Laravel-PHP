<?php

namespace App\Models\Invoice;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'user_id',
        'task_number',
        'title',
        'description',
        'date',
        'time',
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function projects() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function settings() {
        return $this->hasMany(TaskSettings::class, 'task_id', 'id');
    }
    
    public function taskUsers() {
        return $this->hasMany(TaskUser::class, 'task_id', 'id')->with('users');
    }
    public function taskHelper(){
        return $this->belongsToMany('App\Models\Invoice\TasksHelper','task_settings','task_id','setting_id');
    }
    
}
