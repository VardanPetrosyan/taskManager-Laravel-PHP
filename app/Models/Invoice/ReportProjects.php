<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class ReportProjects extends Model
{
    protected $table = 'report_projects';

    protected $fillable = [
        'project_id',
        'report_id'
    ];

    public function projects() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function projectUsers() {
        return $this->belongsTo(ProjectUser::class, 'project_id', 'project_id');
    }

    public function getTasks() {
        return $this->hasMany(Task::class, 'project_id', 'project_id');
    }
}
