@extends('layout')

@section('content')
    <div>
        <div class="row header">
            <div class="col-lg-12">
                <h1 class="col-md-6">Order #{{ $order->id }}</h1>
                <div class="actions col-md-6 no-padding-right">
                    <div class="links">
                        <a class="btn orange" href="{{ route('orders.edit', ['id' => $order->id]) }}">
                            <i class="glyphicon glyphicon-pencil"></i>
                            Edit order
                        </a>
                        <a class="btn red" href="{{ route('orders.create') }}">
                            <i class="glyphicon glyphicon-trash"></i>
                            Delete order
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <order-single :id="{{ $order->id }}"></order-single>
    </div>
@endsection