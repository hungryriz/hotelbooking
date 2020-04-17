<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'shop_id',
        'position',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    //protected $with = ['subcategories'];

    /**
     * Category Images
     */
    public function images()
    {
        return $this->hasMany('App\CategoryImage');
    }

    /**
     * Category Images
     */
    public function subcategories()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');
    }

    /**
     * Products belonging to the category
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')->where('status','enabled')->orderBy(\DB::raw('ISNULL(position), position'),'ASC');;
    }

    /**
     * Get the list of all categories along with subcategories and images.
     */
    public function scopeList($query, $shop_id = NULL,$user_id = NULL)
    {
        return $query->with(['products','products.prices','products.images','products.addons','products.cart' => function($query) use ($user_id){
                return $query->where('user_id', $user_id);
            },'products.cart.cart_addons'])->where('shop_id',$shop_id)->get();
    }

    /**
     * Get the list of all categories along with subcategories and images.
     */
    public function scopeListwithsubcategory($query, $shop_id = NULL,$user_id = NULL)
    {
        return $query->with(['subcategories.products','subcategories.products.prices','subcategories.products.images','subcategories.products.addons','subcategories.products.cart' => function($query) use ($user_id){
                return $query->where('user_id', $user_id);
            }])->where('shop_id',$shop_id)->get();
    }

    /**
     * Get the list of all products that belong to the category with prices and images.
     */
    public function scopeProductList($query, $shop_id = NULL)
    {
        return $query->where('shop_id',$shop_id)->with('products', 'products.images', 'products.prices', 'products.variants', 'products.variants.images', 'products.variants.prices');
    }
}