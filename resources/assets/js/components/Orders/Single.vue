<template>
    <div id="order-single" class="col-xs-12">
        <div class="col-xs-12 holder">
            <div class="col-xs-8 order">
                <div class="col-md-12 order-progress no-padding-left no-padding-right">
                    <div class="col-md-12"></div>
                    <div class="col-md-2 stage">
                        <div class="icon" v-bind:class="{ active: order.stage >= 1 }">
                            <i class="glyphicon glyphicon-folder-close col-md-12"></i>
                        </div>
                        <span class="status">Placed</span>
                        <span class="date">23/04/2015</span>
                    </div>
                    <div class="col-md-2 stage">
                        <div class="icon" v-bind:class="{ active: order.stage >= 2 }">
                            <i class="glyphicon glyphicon-folder-close col-md-12"></i>
                        </div>
                        <span class="status">Processed</span>
                        <span class="date">23/04/2015</span>
                    </div>
                    <div class="col-md-2 stage">
                        <div class="icon" v-bind:class="{ active: order.stage >= 3 }">
                            <i class="glyphicon glyphicon-folder-close col-md-12"></i>
                        </div>
                        <span class="status">Delivered</span>
                        <span class="date">23/04/2015</span>
                    </div>
                    <div class="col-md-2 stage">
                        <div class="icon" v-bind:class="{ active: order.stage >= 4 }">
                            <i class="glyphicon glyphicon-folder-close col-md-12"></i>
                        </div>
                        <span class="status">Completed</span>
                        <span class="date">23/04/2015</span>
                    </div>
                </div>

                <div class="entity-table">
                    <table class="table listing">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in order.products">
                                <td>{{ product.name }}</td>
                                <td>{{ product.quantity }}</td>
                                <td>£{{ product.price }}</td>
                            </tr>
                            <tr class="total">
                                <td></td>
                                <td></td>
                                <td>£{{ order.value }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="col-xs-4 customer">
                <h4>Customer Details</h4>
                <table class="customer-details">
                    <tr>
                        <td><i class="fa fa-user" aria-hidden="true"></i></td>
                        <td>{{ order.customer.firstname }} {{ order.customer.surname }}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope" aria-hidden="true"></i></td>
                        <td>{{ order.customer.email }}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-phone" aria-hidden="true"></i></td>
                        <td>{{ order.customer.phone }}</td>
                    </tr>
                </table>

                <hr>
                <h4>Delivery Address</h4>
                <div class="addresses">
                    <div class="address col-md-12">
                        <div class="contents">
                            <div class="breakdown">
                                <span>{{ order.address.address_1 }}</span>
                                <span v-if="order.address.address_2">{{ order.address.address_2 }}</span>
                                <span>{{ order.address.town }}</span>
                                <span>{{ order.address.county }}</span>
                                <span>{{ order.address.postcode }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    export default {

        props: {
            id: null
        },

        data: function() {
            return {
                order: null,
            }
        },

        mounted: function () {
            let self = this;
            axios.get(Routes.order.single.replace('{id}', this.id))
            .then(function (response) {
                self.order = response.data;
            })
            .catch(function (error) {});
        },

        methods: {

        }

    }
</script>
