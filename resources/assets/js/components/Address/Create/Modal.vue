<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="createAddressModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-modal" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create an address</h4>
                </div>
                <div class="modal-body">
                    <address-create-form></address-create-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import eventHub from '../../../src/EventHub.js'

    export default {

        methods: {
            closeModal: function() {
                var modal = $('#createAddressModal');
                modal.modal('hide');
            }
        }

    }
</script>
