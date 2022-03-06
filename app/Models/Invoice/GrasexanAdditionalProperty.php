<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrasexanAdditionalProperty extends Model
{
    use SoftDeletes;
    protected $table = 'grasexan_additional_properties';

    protected $fillable = [
        'name',
        'grasexan_name_id'
    ];
}
