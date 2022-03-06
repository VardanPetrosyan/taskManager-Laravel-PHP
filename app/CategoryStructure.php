<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryStructure extends Model
{
    protected $table = "category_structures";
    protected $fillable = ['category','parent_category_id','is_deleted'];


}
