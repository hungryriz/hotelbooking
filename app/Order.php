<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'user_id',
        'shop_id',
        'user_address_id',
        'transporter_id',
        'route_key',
        'dispute',
        'created_at',
        'note',
        'schedule_status',
        'delivery_date',
        'order_otp',
        'order_ready_time',
        'order_ready_status'
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
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'user', 'transporter','vehicles', 'invoice', 'address', 'shop',
        'items', 'items.product', 'items.product.prices','items.product.images','items.cart_addons','ordertiming','disputes','disputes.disputecomment','reviewrating'
    ];

    /**
     * Products belonging to the category
     */
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    /**
     * Transporter assigned for the order
     */
    public function transporter()
    {
        return $this->belongsTo('App\Transporter')->withTrashed();
    }

     /**
     * The services that belong to the user.
     */
    public function incoming_requests()
    {
        return $this->hasMany('App\RequestFilter','request_id','id')->where('status', 0);
    }

    /**
     * Shop which serves the order
     */
    public function shop()
    {
        return $this->belongsTo('App\Shop')->withTrashed();
    }

    /**
     * Delivery address of the order.
     */
    public function address()
    {
        return $this->belongsTo('App\UserAddress', 'user_address_id', 'id')->withTrashed();
        // return $this->belongsTo('App\UserAddress');     # Should work but not working
    }

    /**
     * Products belonging to the category
     */
    public function invoice()
    {
        return $this->hasOne('App\OrderInvoice')->withTrashed();
    }

    /**
     * Products belonging to the category
     */
    public function items()
    {
        return $this->hasMany('App\UserCart')->onlyTrashed();
    }
     /**
     * Products belonging to the category
     */
    public function ordertiming()
    {
        return $this->hasMany('App\OrderTiming');
    }
    /**
     * dispute belonging to the order
     */
    public function disputes()
    {
        return $this->hasMany('App\OrderDispute');
    }
    /**
     * vehicles belonging to the order
     */
    public function vehicles()
    {
        return $this->hasOne('App\TransporterVehicle','id','transporter_vehicle_id');
    }

     /**
     * vehicles belonging to the order
     */
    public function reviewrating()
    {
        return $this->hasOne('App\OrderRating');
    }

    /**
     * Get the items from the cart of the users.
     */
    public function scopeList($query, $user_id)
    {
        return $query->where('user_id', $user_id)->with('user','transporter','shop','user.address','product', 'product.parent', 'product.images', 'product.prices')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get only incoming requests.
     */
    public function scopeIncoming($query)
    {
        return $query->whereIN('status', ['ORDERED','RECEIVED','SEARCHING'])->orderBy('created_at', 'DESC')->get();
    }

     /**
     * Get only incoming requests.
     */
    public function scopeAssigned($query)
    {
        return $query->whereIN('status', ['PROCESSING','ASSIGNED'])->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get only incoming requests.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'CANCELLED')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get only incoming requests.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get only incoming requests.
     */
    public function scopePastorders($query)
    {
        return $query->whereIn('status', ['COMPLETED','CANCELLED'])->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get only incoming requests.
     */
    public function scopeOngoing($query)
    {
        return $query->whereIn('status', [
                'REACHED',
                'PICKEDUP',
                'ARRIVED',
            ])->orderBy('created_at', 'DESC')->get();
    }

     /**
     * Get only incoming requests.
     */
    public function scopeProgress($query)
    {
        return $query->whereIn('status', [
                'ORDERED',
                'RECEIVED',
                'PROCESSING',
                'ASSIGNED',
                'REACHED',
                'PICKEDUP',
                'ARRIVED',
            ])->orderBy('created_at', 'DESC')->get();
    }
}
