<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use App\Http\Transformers\ProductTransformer;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Input;

/**
 * Class Service
 * @package App\Http\Services
 */
class Service
{


    /**
     * @param $model
     * @return array
     */
    public function pagination($model)
    {
        $entityClass = new $model;
        $page = Input::get('page', 1);
        $perPage = Input::get('per-page', 25);
        $showing = ($page * $perPage);
        $total = $entityClass::count();

        if ($total < $showing) {
            $showing = $total;
        }

        return [
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'showing' => $showing,
                'total' => $total
            ]
        ];
    }
}