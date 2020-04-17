<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderInvoice extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'quantity',
        'gross',
        'discount',
        'tax',
        'net',
        'total_pay',
        'tender_pay',
        'payment_mode',
        'status',
        'delivery_charge',
        'wallet_amount',
        'payable',
        'paid',
        'payment_id',
        'ripple_price',
        'DestinationTag'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'deleted_at',
    ];

    /**
     * Products belonging to the category
     */
    public function orders()
    {
        return $this->hasOne('App\Order','id','order_id');
    }

    /**
     * Products belonging to the category
     */
    public function scopeTotalAmount($query,$id)
    {
        return $query->withTrashed()->with('orders')
                ->whereHas('orders', function ($q) use ($id) {
                    $q->where('orders.shift_id', $id);
                    $q->where('orders.status', 'COMPLETED');
                })->sum('net');
    }

}
