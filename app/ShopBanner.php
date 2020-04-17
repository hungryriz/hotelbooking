<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ShopBanner extends Model
{
    use SoftDeletes;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'url',
        'position',
        'status',
        'product_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'shop_id', 'created_at', 'updated_at', 'deleted_at'
    ];

     /**
     * Orders
     */
    public function shop()
    {
        return $this->hasOne('App\Shop','id','shop_id');
    }
     /**
     * Orders
     */
    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
}
