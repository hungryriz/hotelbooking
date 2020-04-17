<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCart extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'user_id', 'promocode_id', 'quantity','note'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Products belonging to the category
     */
    public function product()
    {
        return $this->belongsTo('App\Product')->orderBy(\DB::raw('ISNULL(position), position'),'ASC')->withTrashed();
    }

    /**
     * Products belonging to the category
     */
    public function cart_addons()
    {
        return $this->hasMany('App\CartAddon');
    }

    /**
     * Get the items from the cart of the users.
     */
    public function scopeList($query, $user_id)
    {
        return $query->where('user_id', $user_id)->with(['product', 'product.parent', 'product.images', 'product.prices','product.addons', 'product.shop','cart_addons'])->get();
    }
}
