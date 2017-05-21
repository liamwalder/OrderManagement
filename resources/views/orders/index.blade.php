@extends('layout')

@section('content')
    <div class="row header">
        <div class="col-lg-12">
            <h1 class="col-md-6">Orders</h1>
            <div class="actions col-md-6 no-padding-right">
                <form class="col-md-4 col-xl-5 col-lg-8 col-lg-offset-2 col-xl-offset-5">
                    <search :api-url="'/api/orders'"></search>
                </form>
                <a class="btn green" href="{{ route('orders.create') }}">
                    <i class="glyphicon glyphicon-plus"></i>
                    Create an order
                </a>
            </div>
        </div>
    </div>
    <order-table-listing
        :columns="['id', 'created_at', 'customer', 'address', 'stage', 'total']"
        :api-url="'{{ route('api.order.listing') }}?l='"
    >

    </order-table-listing>
@endsection