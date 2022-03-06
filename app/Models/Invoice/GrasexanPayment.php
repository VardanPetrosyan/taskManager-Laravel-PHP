<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class GrasexanPayment extends Model
{
    protected $table = "grasexan_payments";

    protected $fillable = [
        'data_id',
        'payment',
        'images',
        'date'
    ];
}
