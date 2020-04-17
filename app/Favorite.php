<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Favorite extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'shop_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];


     /**
     * Shop
     */
    public function shop()
    {
        return $this->hasOne('App\Shop','id','shop_id');
    }


    public function scopeAvalability($query,$status){

        $query->with('shop') ->whereHas('shop', function ($q) use ($status) {
                    $q->where('shops.status', $status);
                });
    }

}
