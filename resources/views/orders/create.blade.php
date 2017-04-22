@extends('layout')

@section('content')
    <div id="order-creation">
        <div class="row header">
            <div class="col-lg-12">
                <h1 class="col-md-6">Create an order</h1>
                {{--<div class="actions col-md-6 no-padding-right">--}}
                    {{--<button class="btn green">--}}
                        {{--<i class="glyphicon glyphicon-plus"></i>--}}
                        {{--Complete Order--}}
                    {{--</button>--}}
                {{--</div>--}}
            </div>
        </div>
        <create-order></create-order>
    </div>
@endsection