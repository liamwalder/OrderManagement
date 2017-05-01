<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stage
 * @package App
 */
class Stage extends Model
{
    /**
     * @var array
     */
    public $fillable = [ 'name', 'classes' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order')->withTimestamps();
    }


}
