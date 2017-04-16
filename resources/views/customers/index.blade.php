@extends('layout')

@section('content')
    <div id="customers">
        <div class="row header">
            <div class="col-lg-12">
                <h1 class="col-md-6">Customers</h1>
                <div class="actions col-md-6 no-padding-right">
                    <form class="col-md-4 col-xl-5 col-lg-8 col-lg-offset-2 col-xl-offset-5">
                        <search :api-url="'/api/customers'"></search>
                    </form>
                    <button class="btn green" data-toggle="modal" data-target="#createCustomerModal">
                        <i class="glyphicon glyphicon-plus"></i>
                        Create a customer
                    </button>
                </div>
            </div>
        </div>
        <customer-table-listing
            :columns="['firstname', 'surname', 'email', 'phone', 'addresses']"
            :api-url="'{{ route('api.customer.listing') }}?l='"
            :deletion-modal-id="'#deleteCustomModal'"
        >
        </customer-table-listing>

        <customer-create-modal></customer-create-modal>
        <address-edit-modal></address-edit-modal>
        <customer-delete-modal></customer-delete-modal>
        <address-delete-modal></address-delete-modal>
        <customer-edit-modal></customer-edit-modal>
        <address-create-modal></address-create-modal>
    </div>
@endsection

@section('footer_javascript')
    {{--<script>--}}
        {{--var modal = $('#createCustomerModal');--}}
        {{--modal.on('hidden.bs.modal', function () {--}}
            {{--modal.find('.errors').empty();--}}
            {{--modal.find('.addresses').empty();--}}
            {{--var inputs = modal.find(':input');--}}
            {{--$.each(inputs, function(key, input) {--}}
               {{--$(input).val('');--}}
            {{--});--}}
        {{--});--}}
{{--//    </script>--}}
@endsection