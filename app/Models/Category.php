<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $table = "category";
    protected $guarded = [];

    public function parentCategory() {
        return $this->hasOne(self::class, 'id', 'parent');
    }

    public function subCategories() {
        return $this->hasMany(self::class, 'parent', 'id');
    }

    public function deepSubCategories(){
        return $this->subCategories()->with('subCategories');
    }
}
