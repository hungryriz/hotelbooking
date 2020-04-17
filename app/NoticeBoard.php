<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class NoticeBoard extends Model
{
   use SoftDeletes;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transporter_id','title','note','notice', 'created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'deleted_at',
    ];

     /**
     * Orders
     */
    public function transporter()
    {
        return $this->hasOne('App\Transporter','id','transporter_id');
    }
}
