<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrasexanData extends Model
{
    use SoftDeletes;
    protected $table = 'grasexan_datas';

    protected $fillable = [
        'grasexan_name_id',
        'data_name_id',
        'add_prop_id',
        'counter_number',
        'unit_price',
        'total_payment',
        'paid',
        'debt'
    ];

    public function names() {
        return $this->belongsTo(GrasexanName::class, 'grasexan_name_id', 'id');
    }
    public function dataName() {
        return $this->belongsTo(GrasexanDataName::class, 'data_name_id', 'id')->withTrashed();
    }
    public function addPropName() {
        return $this->belongsTo(GrasexanAdditionalProperty::class, 'add_prop_id', 'id')->withTrashed();
    }
}
