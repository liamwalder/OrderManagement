<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App
 */
class Product extends Model
{

    use SoftDeletes;

    /**
     * @var array
     */
    public $fillable = [ 'name', 'price', 'description' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order')->withTimestamps();
    }

}
