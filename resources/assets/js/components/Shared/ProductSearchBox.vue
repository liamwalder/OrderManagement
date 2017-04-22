<template>
    <div class="search" id="product-search-box" v-on-clickaway="clickedAway">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-search"></i></span>
            <input name="query" v-on:keyup="search" v-model="searchTerm" placeholder="Product search..." class="form-control" id="search" autocomplete="off">
        </div>
        <ul class="results" v-if="products">
            <li v-if="products" v-for="product in products" class="item" v-on:click="selectProduct(product)">
                <span class="name">{{ product.name }} - £{{ product.price }}</span>
            </li>
            <li v-if="products.length == 0" class="item">
                <span class="name">No results found.</span>
            </li>
        </ul>
    </div>
</template>

<script>

    import { directive as onClickaway } from 'vue-clickaway';

    export default {

        directives: {
            onClickaway: onClickaway
        },

        data: function() {
            return {
                searchTerm: null,
                products: null
            }
        },

        methods: {

            clickedAway() {
                this.searchTerm = null;
                this.products = null;
            },

            search() {
                let self = this;
                if (this.searchTerm.length > 0) {
                    let apiUrl = Routes.product.list + '&search=' + this.searchTerm;
                    axios.get(apiUrl)
                    .then(function (response) {
                        self.products = response.data.entities.items;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                } else {
                    this.products = null;
                }
            },

            selectProduct(product) {
                this.searchTerm = null;
                this.products = null;
                this.$emit('selectedProduct', product);
            }
        }

    }
</script>
