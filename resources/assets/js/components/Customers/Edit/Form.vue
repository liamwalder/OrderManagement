<template>
    <div>

        <form v-on:submit.prevent="submit">
            <errors :errors="errors"></errors>
            <input type="hidden" name="id" v-model="customer.id" />
            <div class="form-group">
                <label>Firstname</label>
                <input type="text" class="form-control" id="firstname" v-model="customer.firstname" placeholder="Firstname" name="firstname" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Surname</label>
                <input type="text" class="form-control" id="surname" v-model="customer.surname" placeholder="Surname" name="surname" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="email" v-model="customer.email" placeholder="Email" name="email" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" id="phone" v-model="customer.phone" placeholder="Phone" name="phone" autocomplete="off">
            </div>

            <hr>
            <h4 id="address-title">Addresses <button type="button" class="btn btn-sm grey" @click="createAddress(customer)"><i class="glyphicon glyphicon-plus"></i> Add new address</button></h4>
            <div class="addresses col-md-12 no-padding-right no-padding-left">
                <div class="address col-md-6" v-for="address in customer.addresses">
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
                            <button class="btn red" type="button" v-if="customer.addresses.length > 1" @click="deleteAddress(address)"><i class="glyphicon glyphicon-trash"></i> Delete</button>
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
                errors: [],
                customer: []
            }
        },

        mounted: function () {
            let self = this;
            eventHub.$on('editCustomer', function (customer) {
                self.customer = JSON.parse(JSON.stringify(customer));
                var modal = $('#editCustomerModal');
                modal.modal('show');
            });

            eventHub.$on('deletedAddress', function () {
                if (self.customer.id) {
                    axios.get(Routes.customer.single.replace('{id}', self.customer.id))
                    .then(function (response) {
                        self.customer = response.data;
                    })
                    .catch(function (error) {
                        self.errors = error.response.data;
                        button.button('reset');
                    });
                }
            });

            eventHub.$on('successfulCreateAddress', function (customer) {
                if (customer.id != null) {
                    axios.get(Routes.customer.single.replace('{id}', self.customer.id))
                    .then(function (response) {
                        self.customer = response.data;
                    })
                    .catch(function (error) {
                        self.errors = error.response.data;
                        button.button('reset');
                    });
                } else {
                    self.customer = customer;
                }
            });

            eventHub.$on('successfulEditAddress', function () {
                if (self.customer.id) {
                    axios.get(Routes.customer.single.replace('{id}', self.customer.id))
                    .then(function (response) {
                        self.customer = response.data;
                    })
                    .catch(function (error) {
                        self.errors = error.response.data;
                        button.button('reset');
                    });
                }
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
                var self = this;
                var button = $('#editCustomerModal button[type="submit"]').button('loading');

                var submission = {
                    _method:   'PATCH',
                    customer: {
                        firstname: this.customer.firstname,
                        surname:   this.customer.surname,
                        email:     this.customer.email,
                        phone:     this.customer.phone
                    }
                };

                axios.post(Routes.customer.edit.replace('{id}', this.customer.id), submission)
                .then(function (response) {
                    button.button('reset');
                    self.$emit('successfulSubmission');
                    eventHub.$emit('successfulSubmission');
                })
                .catch(function (error) {
                    self.errors = error.response.data;
                    button.button('reset');
                });
            }
        }

    }
</script>
