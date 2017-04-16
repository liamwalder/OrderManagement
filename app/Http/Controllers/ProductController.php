<?php

namespace App\Http\Controllers;


class ProductController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view('products.index');
    }

}
