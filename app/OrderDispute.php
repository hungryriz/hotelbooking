<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDispute extends Model
{
   use SoftDeletes;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'user_id',
        'shop_id',
        'transporter_id',
        'type',
        'status',
        'created_by',
        'created_to',
        'description',
        'order_disputehelp_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'deleted_at',
    ];

    protected $with = ['disputeHelp'];

     /**
     * dispute belonging to the order
     */
    public function disputeComment()
    {
        return $this->hasMany('App\OrderDisputeComment');
    }
    /**
     * Shop which serves the order
     */
    public function order()
    {
        return $this->hasOne('App\Order','id','order_id')->withTrashed();
    }

    public function scopeList($query){
        return $query->with('order');
    }

    /**
     * dispute belonging to the order
     */
    public function disputeHelp()
    {
        return $this->belongsTo('App\OrderDisputeHelp','order_disputehelp_id','id');
    }
}
