<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransporterVehicle extends Model
{
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transporter_id',
        'vehicle_no',
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
     * Transporter assigned for the shift
     */
    public function orders()
    {
        return  $this->hasMany('App\Order','transporter_vehicle_id','id');
    }

}
