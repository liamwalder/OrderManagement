<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * Class Order
 * @package App
 */
class Order extends Model
{
    
    use Searchable;

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        $order = $this->toArray();
        $customer = $this->customer->toArray();
        $address = $this->address->toArray();

        return [
            'id' => $order['id'],
            'total' => $order['total'],
            'firstname' => $customer['firstname'],
            'surname' => $customer['surname'],
            'email' => $customer['email'],
            'address_1' => $address['address_1'],
            'address_2' => $address['address_2'],
            'town' => $address['town'],
            'county' => $address['county'],
            'postcode' => $address['postcode'],
        ];
    }
    
    /**
     * @var array
     */
    public $fillable = [ 'customer_id', 'address_id', 'total'];

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
