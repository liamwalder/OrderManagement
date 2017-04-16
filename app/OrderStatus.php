<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderStatus
 * @package App
 */
class OrderStatus extends Model
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
