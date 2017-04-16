<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteAddressModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" name="id" v-model="address.id" />
                    <h4>Are you sure you want to delete this address?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" name="delete" class="btn red" @click="deleteAddress()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin fa-fw'></i>"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import eventHub from '../../../src/EventHub.js'

    export default {

        data: function() {
            return {
                address: []
            }
        },

        mounted: function () {
            let self = this;
            eventHub.$on('deleteAddress', function (address) {
                self.address = JSON.parse(JSON.stringify(address));
                var modal = $('#deleteAddressModal');
                modal.modal('show');
            });
        },

        methods: {
            deleteAddress: function () {
                var self = this;
                var button = $('#deleteAddressModal button[name="delete"]').button('loading');
                let addressId = this.address.id;

                axios.delete(Routes.address.destroy.replace('{id}', this.address.id))
                .then(function (response) {
                    button.button('reset');
                    eventHub.$emit('deletedAddress', addressId);
                    eventHub.$emit('successfulSubmission');
                    $('#deleteAddressModal button[name="close"]').trigger('click');
                })
                .catch(function (error) {
                    self.errors = error.response.data;
                    button.button('reset');
                });
            }
        }

    }
</script>
