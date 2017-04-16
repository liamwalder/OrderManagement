<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="editAddressModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Address</h4>
                </div>
                <div class="modal-body">
                    <address-edit-form v-on:successfulEditAddress="closeModal"></address-edit-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import eventHub from '../../../src/EventHub.js'

    export default {

        methods: {
            closeModal: function () {
                $("#editAddressModal .close-modal").trigger('click');
            }
        }

    }
</script>
