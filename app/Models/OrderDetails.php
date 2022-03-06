<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;


class OrderDetails extends Model
{

    public $timestamps=true;
    protected $table = "order_details";



    public function getOrder(){
            return $this->hasMany(Orders::class, 'details_id', "id", "categoryStructure_id");
    }

    public function approvedOrders(){
        return $this->hasMany(Orders::class, 'details_id', "id", "categoryStructure_id")
            ->where(["orders.status"=>"approved"]);
    }
}
