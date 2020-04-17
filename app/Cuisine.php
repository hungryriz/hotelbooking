<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Cuisine extends Model
{

     use SoftDeletes, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];


     /**
     * Products belonging to the category
     */
    public function shops()
    {
        return $this->belongsToMany('App\Shop');
    }

    /**
     * Get the list of all categories along with variants and images.
     */
    public function scopeList($query)
    {
        return $query->with('shops')->get();
    }

    /**
     * Get the list of all shops that belong to the cuisine .
     */
    public function scopeShopList($query)
    {
        return $query->with('shops');
    }
}
