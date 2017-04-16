<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteProductModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" name="id" />
                    <h3>Are you sure you want to delete this product?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" name="delete" class="btn red" @click="deleteProduct()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin fa-fw'></i>"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import eventHub from '../../../src/EventHub.js'

    export default {

        methods: {
            deleteProduct: function () {
                var self = this;
                var button = $('#deleteProductModal button[name="delete"]').button('loading');

                let hiddenIdInputValue = $('#deleteProductModal input[name="id"]').val();

                axios.delete(Routes.product.destroy.replace('{id}', hiddenIdInputValue))
                    .then(function (response) {
                        button.button('reset');
                        self.$emit('successfulSubmission');
                        eventHub.$emit('successfulSubmission');
                        $('#deleteProductModal button[name="close"]').trigger('click');
                    })
                    .catch(function (error) {
                        self.errors = error.response.data;
                        button.button('reset');
                    });
            }
        }

    }
</script>
