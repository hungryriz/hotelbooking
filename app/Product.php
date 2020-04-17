<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'position',
        'max_quantity',
        'shop_id',
        'featured',
        'addon_status',
        'status',
        'food_type',
        'out_of_stock'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'parent_id', 'pivot'
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    /*protected $with = [
        'images'
    ];
*/
    /**
     * Category Images
     */
    public function images()
    {
        return $this->hasMany('App\ProductImage')->where('position',0)->orderBy('position','DESC');
    }
     public function featured_images()
    {
        return $this->hasMany('App\ProductImage')->where('position',1)->orderBy('position','DESC');
    }

    /**
     * Parent product of a variant.
     */
    public function parent()
    {
        return $this->hasOne('App\Product', 'id', 'parent_id')->withTrashed();
    }

    /**
     * Parent product of a variant.
     */
    public function shop()
    {
        return $this->hasOne('App\Shop', 'id', 'shop_id')->withTrashed();
    }

    /**
     * Variants of the same products.
     */
    public function variants()
    {
        return $this->hasMany('App\Product', 'parent_id', 'id');
    }

    /**
     * Categories that the product belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * Variants of the same products.
     */
    public function prices()
    {
        return $this->hasOne('App\ProductPrice');
    }

    /**
     * Get the list of all categories along with variants and images.
     */
    public function scopeList($query,$shop_id = NULL)
    {
        return $query->where('shop_id',$shop_id)->with('images', 'prices', 'variants', 'variants.images', 'variants.prices','categories','shop.cuisines','addons')->get();
    }

    public function cart()
    {
        return $this->hasMany('App\UserCart','product_id','id');
    }
     /**
     * Cuisines that the shop belongs to.
     */
    public function addons()
    {
        return $this->hasMany('App\AddonProduct');
    }

     public function scopeListfeatured_image($query,$shop_id = NULL,$user_id = NULL)
    {
        return $query->with(['prices','featured_images','images','addons','cart' => function($query) use ($user_id){
                return $query->where('user_id', $user_id);
            },'cart.cart_addons'])->where('shop_id',$shop_id)->where('featured','!=','0')->orderBy('featured','ASC')->get();
    }


    public function scopeListsearch($query,$user_id = NULL,$name){
        return $query->with(['addons','prices','images', 'cart'=> function($query) use ($user_id,$name){
            return $query->where('user_id', $user_id);
        },'cart.cart_addons','shop'])->where('name', 'LIKE', '%' . $name . '%')->get();
    }
    
    /**
     * Variants of the same products.
     */
    public function productcuisines()
    {
        return $this->belongsTo('App\Cuisine', 'cuisine_id', 'id');
    }

}
