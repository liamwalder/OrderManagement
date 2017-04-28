<template>
    <div class="row">

        <div class="col-xs-12 holder">

            <div class="actions col-md-12 no-padding-right">
                <button class="btn btn-md green create-order" v-on:click="placeOrder()">
                    <i class="glyphicon glyphicon-ok-sign"></i>
                    Save Order
                </button>
            </div>

            <hr class="col-md-12">

            <errors :errors="errors"></errors>

            <div class="col-xs-4 customer no-padding-left">
                <div class="section">
                    <h3>Customer</h3>
                    <customer-search-box v-on:selectedCustomer="setCustomer"></customer-search-box>

                    <div v-if="customer">
                        <hr>
                        <h4>Customer Details</h4>
                        <table class="customer-details">
                            <tr>
                                <td><i class="fa fa-user" aria-hidden="true"></i></td>
                                <td>{{ customer.firstname }} {{ customer.surname }}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-envelope" aria-hidden="true"></i></td>
                                <td>{{ customer.email }}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-phone" aria-hidden="true"></i></td>
                                <td>{{ customer.phone }}</td>
                            </tr>
                        </table>

                        <hr>
                        <h4>Delivery Address</h4>
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

            <div class="col-xs-8 no-padding-right">
                <div class="section">
                    <h3>Products</h3>
                    <product-search-box v-on:selectedProduct="addProduct"></product-search-box>
                    <div v-if="products.length > 0" class="entity-table">
                        <table class="table listing">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in products">
                                    <td>
                                        <input type="hidden" v-model="product.id" name="id" />
                                        {{ product.name }}
                                    </td>
                                    <td><input type="text" v-model="product.quantity" name="quantity" v-on:keyup="quantityChange(product)" /></td>
                                    <td>£{{ product.price }}</td>
                                    <td>
                                        <button class="btn btn-block red" @click="removeProduct(index)"><i class="fa fa-times" aria-hidden="true"></i> Remove</button>
                                    </td>
                                </tr>
                                <tr class="total">
                                    <td></td>
                                    <td></td>
                                    <td>£{{ totalPrice }}</td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>

    module.exports =  {

        data: function() {
            return {
                products: [],
                address: [],
                customer: null,
                totalPrice: 0,
                errors: []
            }
        },

        methods: {

            removeProduct(index) {
                this.products.splice(index, 1);
                this.updateTotal();
            },

            quantityChange(product) {
                let price = product.originalPrice;
                let quantity = product.quantity;
                console.log(price);
                console.log(quantity);
                product.price = (Math.round((price * quantity) * 100) / 100).toFixed(2);
                this.updateTotal();
            },

            addProduct(product) {
                let self = this;
                let productAlreadyInList = false;

                this.products.forEach(function(existingProduct, key) {
                   if (existingProduct.id == product.id) {
                       existingProduct.quantity++;
                       self.quantityChange(existingProduct);
                       productAlreadyInList = true;
                   }
                });

                if (productAlreadyInList === false) {
                    product.quantity = 1;
                    product.originalPrice = product.price;
                    this.products.push(product);
                }

                this.updateTotal();
            },

            setAddress(address) {
                this.address = address;
            },

            setCustomer(customer) {
                this.customer = customer;
                if (customer.addresses.length == 1) {
                    this.address = this.customer.addresses[0];
                }
            },

            updateTotal() {
                let self = this;
                this.totalPrice = 0;
                this.products.forEach(function (product, key) {
                    self.totalPrice += (product.originalPrice * product.quantity);
                });
                this.totalPrice = Math.round(this.totalPrice * 100) / 100;
                this.totalPrice = this.totalPrice.toFixed(2);
            },

            placeOrder() {
                let products = [];
                this.products.forEach(function (product, key) {
                    products.push({
                        id: product.id,
                        quantity: product.quantity
                    });
                });

                let submission = {
                    order: {
                        address_id: this.address.id,
                        products: products
                    }
                };

                if (this.customer !== null) {
                    submission.order.customer_id = this.customer.id;
                }

                this.sendOrderRequest(submission);
            },

            sendOrderRequest(submission) {
                let self = this;

                axios.post(Routes.order.create, submission)
                .then(function (response) {
                    window.location = "/orders";
                })
                .catch(function (error) {
                    self.errors = error.response.data;
                });
            }

        }

    }

</script>
