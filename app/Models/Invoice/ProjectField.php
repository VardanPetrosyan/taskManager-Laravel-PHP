<?php

namespace App\Models\Invoice;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectField extends Model
{
    use SoftDeletes;

    protected $table = 'projects_fields';

    protected $fillable = [
        'project_id',
        'setting_id',
        'Default',
        'EmptyOrNot'
    ];

    public function settings() {
        return $this->belongsTo(TasksHelper::class, 'setting_id', 'id');
    }

    public function projects() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
   

}
