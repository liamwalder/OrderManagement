<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App
 */
class Order extends Model
{
    /**
     * @var array
     */
    public $fillable = [ 'customer_id', 'address_id' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stages()
    {
        return $this->belongsToMany('App\Stage')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Address');
    }

}
