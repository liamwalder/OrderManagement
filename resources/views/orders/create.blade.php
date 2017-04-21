@extends('layout')

@section('content')
    <div class="row header">
        <div class="col-lg-12">
            <h1 class="col-md-6">Create an order</h1>
        </div>
    </div>


    <div class="row" id="order-creation">
        <div class="col-xs-12">

            <div class="col-xs-4">
                <div class="section">
                    <h3>Customer</h3>
                    <customer-search-box></customer-search-box>
                    <hr>
                </div>
            </div>

            <div class="col-xs-8">
                <div class="section">
                    <h3>Order</h3>
                </div>
            </div>

        </div>
    </div>

@endsection