<template>
    <div class="col-xs-12 no-padding-left no-padding-right">
        <div class="col-md-3 no-padding-left">
            <order-statistic-widget :orders="orders.placed" title="Placed Orders" color="blue"></order-statistic-widget>
        </div>
        <div class="col-md-3">
            <order-statistic-widget :orders="orders.processed" title="Processed Orders" color="purple"></order-statistic-widget>
        </div>
        <div class="col-md-3">
            <order-statistic-widget :orders="orders.delivered" title="Delivered Orders" color="green"></order-statistic-widget>
        </div>
        <div class="col-md-3 no-padding-right">
            <order-statistic-widget :orders="orders.completed" title="Completed Orders" color="red"></order-statistic-widget>
        </div>
    </div>
</template>

<script>
    export default {

        data: function() {
            return {
                orders: []
            }
        },

        created: function() {
            let vm = this;
            axios.get('/api/dashboard')
            .then(function (response) {
                vm.orders = response.data.orders;
            })
            .catch(function (error) {
                console.log(error);
            });
        }

    }
</script>
