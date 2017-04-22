<template>
    <div class="row" id="order-creation">
        <div class="col-xs-12 holder">

            <div class="col-xs-4 customer">
                <div class="section">
                    <customer-search-box v-on:selectedCustomer="setCustomer"></customer-search-box>

                    <div v-if="customer">
                        <hr>

                        <h3>Customer Details</h3>
                        <ul class="customer-details">
                            <li><i class="fa fa-user" aria-hidden="true"></i> {{ customer.firstname }} {{ customer.surname }}</li>
                            <li><i class="fa fa-envelope" aria-hidden="true"></i> {{ customer.email }}</li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i> {{ customer.phone }}</li>
                        </ul>

                        <h3>Delivery Address</h3>
                        <div class="addresses col-md-12 no-padding-left no-padding-right">
                            <div class="address col-md-6" v-for="customerAddress in customer.addresses" v-bind:class="{ selected: customerAddress.id == address.id }">
                                <div class="contents">
                                    <div class="breakdown">
                                        <span>{{ customerAddress.address_1 }}</span>
                                        <span v-if="customerAddress.address_2">{{ customerAddress.address_2 }}</span>
                                        <span>{{ customerAddress.town }}</span>
                                        <span>{{ customerAddress.county }}</span>
                                        <span>{{ customerAddress.postcode }}</span>
                                        <div class="actions" v-if="customer.addresses.length > 1">
                                            <button type="button" class="btn green" v-on:click="setAddress(customerAddress)" v-if="customerAddress.id != address.id">Select</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-8">
                <div class="section">
                    <h3>Products</h3>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    export default {

        data: function() {
            return {
                address: [],
                customer: null
            }
        },

        methods: {

            setAddress(address) {
                this.address = address;
            },

            setCustomer(customer) {
                this.customer = customer;
                if (customer.addresses.length == 1) {
                    this.address = this.customer.addresses[0];
                }
            }

        }

    }

</script>
