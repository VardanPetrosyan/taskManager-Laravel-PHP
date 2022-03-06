<?php

namespace App\Models\Invoice;
use App\Models\Invoice\GrasexanDataName;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrasexanName extends Model
{
    use SoftDeletes;
    use Sluggable;
    protected $table = 'grasexan_names';

    protected $fillable = [
        'name',
        'grasexan_id',
        'slug',
        'unit',
        'add_prop'
    ];

    public function names() 
    {
        return $this->hasMany(GrasexanDataName::class, 'grasexan_name_id', 'id');
    }

    public function additional_names()
    {
        return $this->hasMany(GrasexanAdditionalProperty::class, 'grasexan_name_id', 'id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
