<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManageApp extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manage_app';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pass_code',
        'base_url',
        'status',
        'client_id',
        'client_secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at', 'deleted_at',
    ];
}
