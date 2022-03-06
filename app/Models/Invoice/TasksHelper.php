<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Invoice\TaskUser;
use App\Models\Invoice\Task;
use App\Models\Invoice\TaskSettings;
use App\Models\Invoice\User;



class TasksHelper extends Model
{
    use SoftDeletes;

    protected $table = 'tasks_helper';

    protected $fillable = [
        'name',
        'properties' => 'array'
    ];

    public function taskUser(){
    return $this->belongsToMany('App\Models\Invoice\Task','task_settings','task_id','setting_id');
    }
    public function projectFields(){
        return $this->hasMany('App\Models\Invoice\ProjectField','setting_id','id');
        }
    public function taskSetting() {
        return $this->hasMany(TaskSettings::class, 'setting_id', 'id')->with('settings');
    }

    public function users(){
        return $this->belongsTo(User::class, 'create_in', 'id');
    }


   
    
    
}
