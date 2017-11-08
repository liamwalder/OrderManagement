<script>

    import OrderScreenMixin from './Screen.vue';

    export default {

        props: {
            id: null
        },

        mixins: [ OrderScreenMixin ],

        data: function() {
            return {
                products: [],
                address: [],
                customer: null,
                totalPrice: null
            }
        },

        mounted: function () {
            let self = this;
            axios.get(Routes.order.single.replace('{id}', this.id))
            .then(function (response) {
                self.products = response.data.products;
                self.customer = response.data.customer;
                self.address = response.data.address;
                self.totalPrice = response.data.value;
                self.updateTotal();
            })
            .catch(function (error) {});
        },



        methods: {

            sendOrderRequest(submission) {
                let self = this;
                submission._method = 'PATCH';
                axios.post(Routes.order.edit.replace('{id}', this.id), submission)
                .then(function (response) {
                    window.location = "/orders/" + self.id;
                })
                .catch(function (error) {
                    self.errors = error.response.data;
                });
            }

        }

    }
    
</script>
