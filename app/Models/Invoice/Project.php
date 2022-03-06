<?php

namespace App\Models\Invoice;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'logo',
    ];

    public function projectUsers() {
        return $this->hasMany(ProjectUser::class, 'project_id', 'id')->with('users');
    }

    public function users(){
        return $this->belongsTo(User::class, 'create_in', 'id');
    }
    public function projectFields(){
        return $this->hasMany('App\Models\Invoice\ProjectField','project_id','id');
        }

    public function tasks() {
        $date1 = date_format(new \DateTime(date('Y').'-'.(date('m') - 1).'-'.date('d')), 'Y-m-d');
        $date2 = date_format(new \DateTime(date('Y').'-'.date('m').'-'.date('d')), 'Y-m-d');
        return $this->hasMany(Task::class, 'project_id', 'id')->where([['date', '>=', $date1], ['date', '<=', $date2]]);
    }

}
