@extends('layout')

@section('content')
    <div id="order-creation">
        <div class="row header">
            <div class="col-lg-12">
                <h1 class="col-md-6">Edit order</h1>
            </div>
        </div>
        <edit-order-screen :id="{{ $id }}"></edit-order-screen>
    </div>
@endsection