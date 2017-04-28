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
    public $fillable = [ 'name' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }


}
