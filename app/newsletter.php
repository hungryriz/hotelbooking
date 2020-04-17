<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class newsletter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

     /**
     * Products belonging to the category
     */
    /*public function products()
    {
        return $this->belongsToMany('App\Product');
    }

     public function addon_price(){
        return $this->belongsToMany('App\Addon','addon_product')->withPivot('price');
    }*/
}
