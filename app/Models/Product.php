<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    public const STATUS_PASSIVE = 'passive';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_RESERVE = 'reserve';

    public $timestamps = false;
    public $table = "products";
    public $guarded = [];

    public function categoryObj()
    {
    	return $this->hasOne(Category::class, 'id', 'category');
    }
}
