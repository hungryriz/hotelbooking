<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocode extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promo_code',
        'promocode_type',
        'avail_from',
        'expiration',
        'status',
        'discount',
        'coupon_limit',
        'coupon_user_limit'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The services that belong to the user.
     */
    public function pusage()
    {
        return $this->belongsTo('App\PromocodeUsage','id','promocode_id');
    }
    /**
     * Get the list of all categories along with subcategories and images.
     */
    public function scopeUserPromo($query, $user_id = NULL)
    {
        return $query->with(['pusage' => function($query) use ($user_id){
                return $query->where('user_id','==', $user_id)->where('STATUS','==','USED');
            }]);
    }
}


