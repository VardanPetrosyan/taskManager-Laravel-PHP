<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Furnitures extends Model
{
    protected $table = 'furnitures';
    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'count',
        'user_id',
        'category_id',
        'sended_to_categoryStructure_id',
        'ordered_from_categoryStructure_id',
        'approved',
        'categoryStructure_id',
        'image',
        'ordered',
        'code'
    ];

    
    public function orderedCategoryStructure()
    {
        return $this->hasOne('App\CategoryStructure', 'id', 'ordered_from_categoryStructure_id');
    }

    public function sendedCategoryStructure()
    {
        return $this->hasOne('App\CategoryStructure', 'id', 'sended_to_categoryStructure_id');
    }

}
