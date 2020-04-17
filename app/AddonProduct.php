<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddonProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'addon_id','product_id','price'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    protected $with = ['addon'];
    public function addon()
    {
        return $this->hasOne('App\Addon','id','addon_id');
    }

}
