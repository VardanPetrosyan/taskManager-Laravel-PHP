<?php

namespace App\Models\Invoice;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUser extends Model
{
    use SoftDeletes;

    protected $table = 'project_users';

    protected $fillable = [
        'project_id',
        'user_id'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function projects() {
        return $this->belongsTo(Project::class, 'project_id', 'id')->with('projectUsers');
    }

}
