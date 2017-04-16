<template>
    <div>
        <form v-on:submit.prevent="submit">
            <errors :errors="errors"></errors>
            <input type="hidden" name="id" v-model="product.id" />
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" v-model="product.name" id="name" name="name" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" v-model="product.price" id="price" name="price" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" v-model="product.description" id="description" name="description" rows="6"></textarea>
            </div>
            <button type="submit" class="btn btn-default green" data-loading-text="<i class='fa fa-circle-o-notch fa-spin fa-fw'></i>">Submit</button>
        </form>
    </div>
</template>

<script>
    import eventHub from '../../../src/EventHub.js'

    export default {

        data: function() {
            return {
                errors: [],
                product: []
            }
        },

        mounted: function () {
            let self = this;
            eventHub.$on('editProduct', function (product) {
                self.product = JSON.parse(JSON.stringify(product));
                var modal = $('#editProductModal');
                modal.modal('show');
            });
        },

        methods: {
            submit: function () {
                var self = this;
                var button = $('button[type="submit"]').button('loading');
                let submission = {
                    _method: 'PATCH',
                    product: {
                        name: this.product.name,
                        price: this.product.price,
                        description: this.product.description
                    }
                };

                axios.post(Routes.product.edit.replace('{id}', this.product.id), submission)
                .then(function (response) {
                    button.button('reset');
                    self.$emit('successfulSubmission');
                    eventHub.$emit('successfulSubmission');

                    self.id = null;
                    self.name = null;
                    self.price = null;
                })
                .catch(function (error) {
                    self.errors = error.response.data;
                    button.button('reset');
                });
            }
        }

    }
</script>
