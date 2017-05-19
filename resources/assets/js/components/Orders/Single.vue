<template>
    <div id="order-single" class="col-xs-12">
        <div class="col-xs-12 holder">

            <div class="col-xs-8 order">
                <div class="col-md-12 order-progress no-padding-left no-padding-right">
                    <div class="col-md-12"></div>
                    <div class="col-md-2 stage" v-for="(stage, index) in order.stages">
                        <div class="icon" v-bind:class="{ active: order.stage_id >= stage.id }" v-html="stage.classes"></div>
                        <span class="status">{{ stage.name }}</span>
                        <span class="date">{{ stage.created }}</span>
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
                <table class="customer-details" v-if="order.customer">
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
                            <div class="breakdown" v-if="order.address">
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

            <div class="col-md-12" v-if="nextStage">
                <hr>
                <div class="actions col-md-12 no-padding-right">
                    <button class="btn btn-md green create-order" @click="progressOrder(nextStage)">
                        <i class="glyphicon glyphicon-ok-sign"></i>
                        Mark as {{ nextStage.name }}
                    </button>
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
                order: [],
                nextStage: null
            }
        },

        mounted: function () {
            this.getOrder();
        },

        methods: {

            getOrder() {
                let self = this;
                axios.get(Routes.order.single.replace('{id}', this.id))
                .then(function (response) {
                    self.order = response.data;
                    self.workOutNextStage();
                })
                .catch(function (error) {});
            },

            progressOrder(nextStage) {
                let self = this;

                var submission = {
                    order: {
                        status: nextStage.id
                    }
                };
                submission._method = 'PATCH';

                axios.post(Routes.order.edit.replace('{id}', this.id), submission)
                .then(function (response) {
                    self.getOrder();
                })
                .catch(function (error) {});
            },

            workOutNextStage() {
                let self = this;
                let stages = this.order.stages;
                let foundNextStage = false;
                stages.forEach(function(stage, key) {
                    if (stage.created == null && foundNextStage == false) {
                        stage.name = stage.name.toLowerCase();
                        self.nextStage = stage;
                        foundNextStage = true;
                    }
                });

                if (foundNextStage == false) {
                    self.nextStage = null;
                }

            }


        }

    }
</script>
