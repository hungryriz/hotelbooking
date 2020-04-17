<?php

namespace App;

use App\Notifications\TransporterResetPassword;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transporter extends Authenticatable
{
    use SoftDeletes, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'name', 'email', 'phone', 'password', 'avatar', 'latitude', 'longitude','device_id','device_type','device_token','status','address','rating'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function findForPassport($username) {
        return $this->where('phone', $username)->first();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new TransporterResetPassword($token));
    }

    /**
     * Orders
     */
    public function orders()
    {
        $instance = $this->hasMany('App\Order');
        $instance->getQuery()->whereNotIn('status', ['CANCELLED','COMPLETED']);
        return $instance;
    }

    /**
     * vehicles
     */
    public function vehicles()
    {
        return $this->hasMany('App\TransporterVehicle');
    }

     /**
     * Orders
     */
    public function disputes()
    {
        return $this->hasMany('App\OrderDispute','transporter_id','id')->withTrashed();
    }

     /**
     * shift
     */
    public function shift()
    {
        return  $this->hasOne('App\TransporterShift')->get();
      
    }
}
