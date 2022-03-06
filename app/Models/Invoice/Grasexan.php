<?php

namespace App\Models\Invoice;
use App\Models\Invoice\GrasexanName;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grasexan extends Model
{
    use Sluggable;
    use SoftDeletes;
    protected $table = 'grasexans';

    protected $fillable = ['name', 'slug'];

    public function fields()
    {
        return $this->hasMany(GrasexanName::class, 'grasexan_id', 'id');
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
