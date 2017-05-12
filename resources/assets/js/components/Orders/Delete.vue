<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteOrderModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" name="id" v-model="id" />
                    <h4>Are you sure you want to delete this order?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" name="delete" class="btn red" @click="deleteOrder()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin fa-fw'></i>"><i class="glyphicon glyphicon-trash"></i> Delete</button>
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

        methods: {
            deleteOrder: function () {
                var self = this;
                var button = $('#deleteOrderModal button[name="delete"]').button('loading');

                let hiddenIdInputValue = $('#deleteOrderModal input[name="id"]').val();

                axios.delete(Routes.order.destroy.replace('{id}', hiddenIdInputValue))
                .then(function (response) {
                    $('#deleteCustomerModal button[name="close"]').trigger('click');
                    window.location = '/orders';
                })
                .catch(function (error) {
                    self.errors = error.response.data;
                    button.button('reset');
                });
            }
        }

    }
</script>
