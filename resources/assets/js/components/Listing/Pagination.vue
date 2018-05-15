
<template>
    <div class="pagination col-md-12">
        <div class="showing col-md-6 no-padding-left">
            <p class="col-md-12 col-lg-12 no-padding-left">Showing {{ pagination.showing }} of {{ pagination.total }}</p>
        </div>
        <div class="next-prev col-md-6 no-padding-right">
            <div class="buttons">
                <button class="btn" v-on:click="prevPage()"><i class="glyphicon glyphicon-chevron-left"></i> Prev</button>
                <button class="btn" v-on:click="nextPage()">Next <i class="glyphicon glyphicon-chevron-right"></i></button>
            </div>
            <div class="col-md-3 per-page">
                <select class="form-control" @change="perPageChange" v-model="perPage">
                    <option value="10">Show 10</option>
                    <option value="25">Show 25</option>
                    <option value="50">Show 50</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        props: {
            pagination: null
        },

        data: function() {
            return {
                perPage : 25
            }
        },

        methods: {
            perPageChange: function() {
                this.$emit('perPageChange', this.perPage);
            },
            nextPage: function () {
                this.$emit('nextPage');
            },
            prevPage: function () {
                this.$emit('prevPage');
            }
        }

    }
</script>
