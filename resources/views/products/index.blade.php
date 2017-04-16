@extends('layout')

@section('content')
    <div class="row header">
        <div class="col-lg-12">
            <h1 class="col-md-6">Products</h1>
            <div class="actions col-md-6 no-padding-right">
                <form class="col-md-4 col-xl-5 col-lg-8 col-lg-offset-2 col-xl-offset-5">
                    <search :api-url="'/api/products'"></search>
                </form>
                <button class="btn green" data-toggle="modal" data-target="#createProductModal">
                    <i class="glyphicon glyphicon-plus"></i>
                    Create a product
                </button>
            </div>
        </div>
    </div>
    <product-table-listing
            :columns="['name', 'price', 'description']"
            :api-url="'{{ route('api.product.listing') }}?l='"
            :deletion-modal-id="'#deleteProductModal'"
    >
    </product-table-listing>
    <product-create-modal></product-create-modal>
    <product-delete-modal></product-delete-modal>
    <product-edit-modal></product-edit-modal>
@endsection