<template>
    <div v-if="orders">
        <div class="panel panel-default order-statistic-widget">
            <div class="panel-body" :class="color">
                <h3>{{ title }}</h3>
                <div class="col-md-4">
                    <h4>Today</h4>
                    <h4>{{ orders.today.length }}</h4>
                </div>
                <div class="col-md-4">
                    <h4>Week</h4>
                    <h4>{{ orders.week.length }}</h4>
                </div>
                <div class="col-md-4">
                    <h4>Month</h4>
                    <h4>{{ orders.month.length }}</h4>
                </div>
            </div>

            <div class="latest">
                <h5>Latest</h5>
                <table class="table">
                    <tbody>
                    <tr v-for="(order, index) in limitFor(orders.all, 5)">
                        <td><a href="#">{{ order.created_at | formatDateTimeUK }} - {{ order.user.name }}</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'orders', 'color'],

        methods:{
            limitFor: function(items, limit) {
                return items.slice(0, limit);
            }
        }
    }
</script>
