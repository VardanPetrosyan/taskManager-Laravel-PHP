<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrasexanDataName extends Model
{
    use SoftDeletes;
    
    protected $table = 'grasexan_data_names';
    protected $fillable = [
        'grasexan_name_id',
        'name'
    ];

}
