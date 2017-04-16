<template>
    <div>
        <form v-on:submit.prevent="submit">
            <errors :errors="errors"></errors>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name" v-model="name"name="name" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" id="price" v-model="price" name="price" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" v-model="description" id="description" name="description" rows="6"></textarea>
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
                name: null,
                price: null,
                description: null,
                errors: []
            }
        },

        mounted: function () {
            let self = this;
            var modal = $('#createProductModal');
            modal.on('hidden.bs.modal', function () {
                self.name = null;
                self.price = null;
                self.errors = []
            });
        },

        methods: {
            submit: function () {
                var button = $('button[type="submit"]').button('loading');
                var self = this;
                var submission = {
                    product: {
                        name: this.name,
                        price: this.price,
                        description: this.description
                    }
                }
                axios.post(Routes.product.create, submission)
                .then(function (response) {
                    button.button('reset');
                    self.$emit('successfulSubmission');
                    eventHub.$emit('successfulSubmission');

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
