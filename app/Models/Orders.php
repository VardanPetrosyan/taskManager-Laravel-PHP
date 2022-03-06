<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CANCELED_BY_ADMIN = 'canceled_by_admin';
    public const STATUS_CANCELED_BY_CUSTOMER = 'canceled_by_customer';
    public const STATUS_COMPLETE = 'complete';
    public const STATUS_ARCHIVE = 'archive';
    public const STATUS_APPROVE = 'approved';

    public $timestamps=true;
    public $table="orders";
    public $guarded=[];

//    protected $fillable = [
//        'status',
//    ];


    public function getImage()
    {
        if($this->image == null)
        {
            return '/img/no-image.png';
        }

        return '/uploads/' . $this->image;

    }
    public function removeImage()
    {
        if($this->image != null)
        {
            Storage::delete('uploads/' . $this->image);
        }
    }
    public static function add($fields)
    {
        $product = new static;
        $product->fill($fields);
        $product->save();

        return $product;
    }
    public function uploadImage($image)
    {
        if($image == null) { return; }

        $this->removeImage();
        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }
}
