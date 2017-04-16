<template>
    <div class="search">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-search"></i></span>
            <input name="query" v-model="searchTerm" placeholder="Search..." class="form-control" id="search">
        </div>
    </div>
</template>

<script>

    import eventHub from '../../src/EventHub.js'

    export default {

        props: {
            apiUrl: null
        },

        data: function() {
            return {
                searchTerm: null
            }
        },

        watch: {
            searchTerm: function () {
                eventHub.$emit('search', this.searchTerm);
            }
        }

    }
</script>
