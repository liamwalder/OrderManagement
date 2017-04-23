<template>
    <div>
        <form v-on:submit.prevent="submit">
            <errors :errors="errors"></errors>
            <div class="form-group">
                <label>Address Line 1</label>
                <input type="text" class="form-control" id="address_1" v-model="address.address_1" name="address_1" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Address Line 2</label>
                <input type="text" class="form-control" id="address_2" v-model="address.address_2" name="address_2" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Town</label>
                <input type="text" class="form-control" id="town" v-model="address.town" name="town" autocomplete="off">
            </div>
            <div class="form-group">
                <label>County</label>
                <input type="text" class="form-control" id="county" v-model="address.county" name="county" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Postcode</label>
                <input type="text" class="form-control" id="postcode" v-model="address.postcode" name="postcode" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-default green" data-loading-text="<i class='fa fa-circle-o-notch fa-spin fa-fw'></i>">Save</button>
        </form>
    </div>
</template>

<script>
    import eventHub from '../../../src/EventHub.js'

    export default {

        data: function() {
            return {
                customer: [],
                address: [],
                addresses: [],
                errors: []
            }
        },

        mounted: function () {
            let self = this;
            eventHub.$on('createAddress', function (customer) {
                self.customer = customer;
                var modal = $('#createAddressModal');
                modal.on('hidden.bs.modal', function () {
                    self.address = [];
                    self.errors = [];
                });
                modal.modal('show');
            });
        },

        methods: {
            submit: function () {
                var button = $('#createAddressModal button[type="submit"]').button('loading');
                var self = this;

                var submission = {
                    address: {
                        customer_id: this.customer.id,
                        address_1: this.address.address_1,
                        address_2: this.address.address_2,
                        town: this.address.town,
                        county: this.address.county,
                        postcode: this.address.postcode
                    }
                };
                axios.post(Routes.address.create, submission)
                .then(function (response) {
                    if (self.customer.id == null) {
                        self.customer.addresses = [];
                        self.customer.addresses.push(response.data)
                    }
                    button.button('reset');
                    eventHub.$emit('successfulCreateAddress', self.customer);
                    self.address = [];
                    var modal = $('#createAddressModal');
                    modal.modal('hide');
                })
                .catch(function (error) {
                    self.errors = error.response.data;
                    button.button('reset');
                });

            }
        }

    }
</script>
