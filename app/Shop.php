<?php

namespace App;

use App\Notifications\ShopResetPassword;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Authenticatable
{
    use SoftDeletes, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'description',
        'offer_min_amount',
        'offer_percent',
        'estimated_delivery_time',
        'address',
        'maps_address',
        'latitude',
        'longitude',
        'pure_veg',
        'status',
        'default_banner',
        'rating',
        'rating_status',
        'popular',
        'device_type',
        'device_token',
        'device_id',
        'otp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ShopResetPassword($token));
    }

    /**
     * Get the list of all categories along with subcategories and images.
     */
    /*public function scopeList($query, $user_id = NULL)
    {
        return $query->with(['cuisines','timings','ratings','categories','categories.products','categories.products.prices', 'categories.products.cart' => function($query) use ($user_id){
                return $query->where('user_id', $user_id);
            }
        ]);
    }*/

    /**
     * Get the list of all categories along with subcategories and images.
     */
    public function scopeList($query, $user_id = NULL,$cat = NULL,$prodname = NULL, $prodtype = NULL)
    {
        return $query->with(['cuisines','timings','ratings',
            'categories'=> function($q) use ($cat){
                if($cat != NULL){
                    $q->where('name','LIKE', '%' . $cat . '%');
                }
            }
            ,'categories.products'=> function($q) use ($prodname,$prodtype){
                if($prodname!=NULL){
                    $q->where('products.name','LIKE', '%' . $prodname . '%');
                }
                if($prodtype!=NULL){
                    $q->where('products.food_type','=',$prodtype );
                }

            },'categories.products.prices','categories.products.images','categories.products.addons',
            'favorite' => function($q) use ($user_id){
                $q->where('user_id',$user_id);
            }]);
    }


    public function scopeListsubcategory($query, $user_id = NULL,$cat = NULL,$subcat = NULL)
    {
        return $query->with(['cuisines','timings','ratings',
            'categories'=> function($q) use ($cat){
                $q->where('name','LIKE', '%' . $cat . '%');
            }
            ,'categories.subcategories'=> function($q) use ($subcat){
                $q->where('name','LIKE', '%' . $subcat . '%');
            },
            'categories.subcategories.products','categories.subcategories.products.prices','categories.subcategories.products.images','categories.subcategories.products.addons','favorite'=> function($q) use ($user_id){
                    $q->where('user_id',$user_id);
        }]);
    }

    /**
     * Cuisines that the shop belongs to.
     */
    public function cuisines()
    {
        return $this->belongsToMany('App\Cuisine');
    }

    /**
     * opening time that the shop belongs to.
     */
    public function timings()
    {
        return $this->hasMany('App\ShopTiming');
    }

     /**
     * products  that the shop belongs to.
     */
    public function categories()
    {
        return $this->hasMany('App\Category')->orderBy(\DB::raw('ISNULL(position), position'),'ASC');;
    }

    /**
     * products  that the shop belongs to.
     */
    public function products()
    {
        return $this->hasMany('App\Product')->orderBy(\DB::raw('ISNULL(position), position'),'ASC');
    }
    /**
     * products  that the shop belongs to.
     */
    public function ratings()
    {
        return $this->hasOne('App\OrderRating','shop_id','id')
                    ->selectRaw('avg(shop_rating) as rating, shop_id')
                    ->groupBy('shop_id');
    }

    /**
     * Get the list of all shops that belong to the cuisine .
     */
    public function scopeProductList($query)
    {
        return $query->with('products', 'timings','ratings','favorite');
    }

    /**
     * Orders
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

     /**
     * Shop
     */
    public function favorite()
    {
        return $this->hasOne('App\Favorite');
    }

     /**
     * Get the list of all shops that belong to the cuisine .
     */
    public function scopePopularity($query)
    {
        return $query->where('rating','>=',4)->orderBy('rating', 'DESC')->get();
    }
     /**
     * Get the list of all shops that belong to the cuisine .
     */
    public function scopeFastdelivery($query5)
    {
        return $query5->where('estimated_delivery_time','<=',30)->orderBy('rating', 'DESC')->get();
    }
    public function scopeOffers($query1)
    {
        return $query1->where('offer_percent','!=',0)->orderBy('rating', 'DESC')->get();
    }
    public function scopeNewshop($query2)
    {
        return $query2->where('created_at','>=',\Carbon\Carbon::now()->month)->orderBy('created_at', 'DESC')->get();
    }
    public function scopeVeg($query3)
    {
        return $query3->where('pure_veg','=',1)->orderBy('rating', 'DESC')->get();
    }
}
