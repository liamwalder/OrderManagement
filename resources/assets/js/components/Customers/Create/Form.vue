<template>
    <div>
        <form v-on:submit.prevent="submit">
            <errors :errors="errors"></errors>
            <div class="form-group">
                <label>Firstname</label>
                <input type="text" class="form-control" id="firstname" v-model="customer.firstname" name="firstname" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Surname</label>
                <input type="text" class="form-control" id="surname" v-model="customer.surname" name="surname" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="email" v-model="customer.email" name="email" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" id="phone" v-model="customer.phone" name="phone" autocomplete="off">
            </div>

            <h4 id="address-title">Addresses <button type="button" class="btn btn-sm grey" @click="createAddress(customer)"><i class="glyphicon glyphicon-plus"></i> Add new address</button></h4>
            <div class="addresses col-md-12 no-padding-right no-padding-left">
                <div class="address col-md-6" v-for="address in addresses">
                    <div class="contents">
                        <div class="breakdown">
                            <span>{{ address.address_1 }}</span>
                            <span>{{ address.address_2 }}</span>
                            <span>{{ address.town }}</span>
                            <span>{{ address.county }}</span>
                            <span>{{ address.postcode }}</span>
                        </div>
                        <div class="actions">
                            <button class="btn grey" type="button" @click="editAddress(address)"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
                            <button class="btn red" type="button" @click="deleteAddress(address)"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </div>
                    </div>
                </div>
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
                addresses: [],
                errors: []
            }
        },

        mounted: function () {
            let self = this;

            var modal = $('#createCustomerModal');
            modal.on('hidden.bs.modal', function () {
                self.customer = [];
                self.addresses = [];
                self.errors = [];
            });

            eventHub.$on('deletedAddress', function (addressId) {
                let addresses = [];
                self.addresses.forEach(function(currentAddress, key) {
                    if (currentAddress !== undefined) {
                        if (currentAddress.id != addressId) {
                            addresses.push(currentAddress);
                        }
                    }
                });
                self.addresses = addresses;
            });

            eventHub.$on('successfulCreateAddress', function (customer) {
                if (customer.addresses.length > 0) {
                    let address = customer.addresses[0];
                    if (address.customer_id == null) {
                        self.addresses.push(customer.addresses[0]);
                    }
                }
            });

            eventHub.$on('successfulEditAddress', function (address) {
                let addresses = [];
                self.addresses.forEach(function(currentAddress, key) {
                    if (currentAddress !== undefined) {
                        if (currentAddress.id == address.id) {
                            addresses.push(address);
                        } else {
                            addresses.push(currentAddress);
                        }
                    }
                });
                self.addresses = addresses;
            });
        },

        methods: {

            createAddress: function(customer) {
                eventHub.$emit('createAddress', customer);
            },

            editAddress: function(address) {
                eventHub.$emit('editAddress', address);
            },

            deleteAddress: function(address) {
                eventHub.$emit('deleteAddress', address);
            },

            submit: function () {
                var button = $('button[type="submit"]').button('loading');
                var self = this;
                let submission = {
                    customer: {
                        firstname: this.customer.firstname,
                        surname:   this.customer.surname,
                        email:     this.customer.email,
                        phone:     this.customer.phone,
                        addresses: this.addresses
                    }
                };

                console.log(submission);
                axios.post(Routes.customer.create, submission)
                .then(function (response) {
                    button.button('reset');
                    self.$emit('successfulSubmission');
                    eventHub.$emit('successfulSubmission');

                    self.addresses = [];
                    self.errors = [];
                    self.customer = [];
                })
                .catch(function (error) {
                    self.errors = error.response.data;
                    console.log(self.errors);
                    button.button('reset');
                });
            }
        }

    }
</script>
