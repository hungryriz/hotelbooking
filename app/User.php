<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use App\Notifications\UserResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use SoftDeletes, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'avatar', 'password','device_id','device_type','device_token','wallet_balance','login_by','social_unique_id'
    ];

    protected $currency = 1;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at',
    ];


    public function findForPassport($username) {
        return $this->where('phone', $username)->first();
    }

    /**
     * Addresses
     */
    public function addresses()
    {
        return $this->hasMany('App\UserAddress');
    }

    /**
     * Wallet
     */
    public function wallet()
    {
        return $this->hasMany('App\WalletPassbook')->orderBy('id','DESC');
    }

    /**
     * Cart
     */
    public function cart()
    {
        return $this->hasMany('App\UserCart');
    }

    /**
     * Orders
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

     /**
     * Orders
     */
    public function disputes()
    {
        return $this->hasMany('App\OrderDispute','user_id','id')->withTrashed();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token));
    }

     /**
     * Profile with cart details
     */
    public function scopeProfile($query,$id)
    {
        return $query->with('addresses','cart','cart.cart_addons','cart.product','cart.product.addons','cart.product.prices','cart.product.images', 'cart.product.shop')->where('id',$id)->first();
    }
}
