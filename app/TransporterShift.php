<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransporterShift extends Model
{
     use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transporter_id',
        'transporter_vehicle_id',
        'start_time',
        'end_time',
        'total_order'
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
    public function transporter()
    {
        return $query = $this->belongsTo('App\Transporter')->getQuery();
    }

     /**
     * Transporter assigned for the shift
     */
    public function vehicle()
    {
        return  $this->belongsTo('App\TransporterVehicle','transporter_vehicle_id','id');
    }

     /**
     * Transporter assigned for the shift
     */
    public function orders()
    {
        return  $this->hasMany('App\Order','shift_id','id');
    }

     /**
     * Transporter assigned for the shift
     */
    public function shiftbreaktimes()
    {
        return  $this->hasMany('App\TransporterShiftTiming','transporter_shift_id','id')->withTrashed();
    }

    /**
     * Transporter assigned for the shift
     */
    public function scopeList($query,$id)
    {
        return $query->with('vehicle','shiftbreaktimes')->where('transporter_id',$id)->get();
    }

}
