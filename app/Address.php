<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Address
 * @package App
 */
class Address extends Model
{

    use SoftDeletes;
    
    /**
     * @var array
     */
    public $fillable = [ 'address_1', 'address_2', 'town', 'county', 'postcode', 'primary', 'customer_id' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}
