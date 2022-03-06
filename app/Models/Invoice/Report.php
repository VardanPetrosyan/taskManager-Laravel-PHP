<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'name',
        'from',
        'to'
    ];

    public function reportProjects() {
        return $this->hasMany(ReportProjects::class, 'report_id', 'id')->with('getTasks', 'projects');
    }

    public function reportUsers() {
        return $this->hasMany(ReportUsers::class, 'report_id', 'id')->with('getUsers');
    }
}
