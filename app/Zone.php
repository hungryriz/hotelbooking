<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'north_east_lat',
        'north_east_lng',
        'south_west_lat',
        'south_west_lng',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValidateLocation($query, $latitude, $longitude)
    {
        return $query->where('north_east_lat', '>', $latitude)
            ->where('south_west_lat', '<', $latitude)
            ->where('north_east_lng', '>', $longitude)
            ->where('south_west_lng', '<', $longitude);
    }
}
