<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="editProductModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit product</h4>
                </div>
                <div class="modal-body">
                    <product-edit-form v-on:successfulSubmission="closeModal"></product-edit-form>
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
                $(".close-modal").trigger('click');
            }
        }

    }
</script>
