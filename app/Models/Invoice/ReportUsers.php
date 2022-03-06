<?php

namespace App\Models\Invoice;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ReportUsers extends Model
{
    protected $table = 'report_users';

    protected $fillable = [
        'user_id',
        'report_id'
    ];

    public function getUsers() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
