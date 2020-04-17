<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CartAddon extends Model
{
   
	 use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_cart_id',
        'addon_product_id',
        'quantity'
    ];
   /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $with = ['addon_product','addon_product.addon'];
     /**
     * Products belonging to the category
     */
    public function addon_product()
    {
        return $this->belongsTo('App\AddonProduct','addon_product_id');
    }

    

}
