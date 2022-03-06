<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FurnHistory extends Model
{
    protected $table = "furn_histories";

    const TYPE_ORDER = 'order';
    const TYPE_CANCEL_ORDER = 'cancel_order';
    const TYPE_ADMIN_CONFIRM = 'admin_confirm';
    const TYPE_ADMIN_DECLINE = 'admin_decline';
    const TYPE_ADMIN_DISAPPROVE = 'admin_disapprove';
    const TYPE_SEND = 'send';
    const TYPE_CANCEL_SEND = 'cancel_send'; //no
    const TYPE_RECEIVE = 'receive';
    const TYPE_CANCEL_RECEIVE = 'cancel_receive'; //no
    const TYPE_ADD_FURN = 'add';
    const TYPE_DELETE_FURN = 'delete';
    const TYPE_EDIT_FURN  = 'edit';

    public static $types = [
        self::TYPE_ORDER ,
        self::TYPE_CANCEL_ORDER ,
        self::TYPE_ADMIN_CONFIRM ,
        self::TYPE_ADMIN_DISAPPROVE ,
        self::TYPE_ADMIN_DECLINE ,
        self::TYPE_SEND ,
        self::TYPE_CANCEL_SEND ,
        self::TYPE_RECEIVE ,
        self::TYPE_CANCEL_RECEIVE ,
        self::TYPE_ADD_FURN ,
        self::TYPE_DELETE_FURN,
        self::TYPE_EDIT_FURN,
    ];

    protected $fillable = [
        'id',
        'name',
        'receiver_categoryStructure_id',
        'categoryStructure_id',
        'user_id',
        'count',
        'type',
        'description',
    ];

    public function user(){
        return $this->hasOne('App\User','id','user_id');
    }

    public function categoryStructure(){
        return $this->hasOne('App\CategoryStructure','id','categoryStructure_id');
    }

    public function receiver(){
        return $this->hasOne('App\CategoryStructure','id','receiver_categoryStructure_id');
    }

}
