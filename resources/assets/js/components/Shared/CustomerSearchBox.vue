<template>
    <div class="search" id="customer-search-box" v-on-clickaway="clickedAway">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-search"></i></span>
            <input name="query" v-on:keyup="search" v-model="searchTerm" placeholder="Search (min. 3 characters)..." class="form-control" id="search" autocomplete="off">
        </div>
        <ul class="results">
            <li v-if="customers" v-for="customer in customers" class="item" v-on:click="setCustomer(customer)">
                <span class="name">{{ customer.firstname }} {{ customer.surname }}</span>
                <ul>
                    <li class="address" v-for="address in customer.addresses">{{ address.address_1 }}, {{ address.address_2 }} {{ address.town }}, {{ address.county }}, {{ address.postcode }}</li>
                </ul>
            </li>
            <li v-if="!customers">
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
                customers: []
            }
        },

        methods: {

            clickedAway() {
                this.searchTerm = null;
                this.customers = [];
            },

            search() {
                let self = this;
                if (this.searchTerm.length > 2) {
                    let apiUrl = Routes.customer.list + '?search=' + this.searchTerm;
                    axios.get(apiUrl)
                    .then(function (response) {
                        self.customers = response.data.entities.items;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                } else {
                    this.customers = [];
                }
            }
        }

    }
</script>
