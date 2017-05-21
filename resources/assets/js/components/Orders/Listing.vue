<template>
    <div class="entity-table">
        <div class="row">

            <pagination
                    :pagination="pagination"
                    v-on:perPageChange="perPageChange"
                    v-on:nextPage="nextPage"
                    v-on:prevPage="prevPage"
            >
            </pagination>

            <table class="table listing">
                <thead>
                <tr>
                    <th v-for="key in columns"
                        @click="sortBy(key)"
                        :class="{ active: sortKey == key }">
                        {{ key | prettify }}
                        <i class="fa fa-sort" v-if="sortOrders[key] == 0" aria-hidden="true"></i>
                        <i class="fa fa-sort-desc" v-if="sortOrders[key] == 1" aria-hidden="true"></i>
                        <i class="fa fa-sort-asc" v-if="sortOrders[key] == 2" aria-hidden="true"></i>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="entry in data">
                    <td v-for="key in columns" v-html="transform(entry[key], key)"></td>
                    <td>
                        <div class="pull-right">
                            <a class="btn btn-sm blue hollow" @click="view(entry)"><i class="fa fa-eye" aria-hidden="true"></i> View Order</a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script>
    import ListingMixin from '../Listing/Table.vue';
    import eventHub from '../../src/EventHub.js';

    export default {

        mixins: [ ListingMixin ],

        mounted: function () {
            var self = this;
            eventHub.$on('search', function (searchTermValue) {
                self.search(searchTermValue);
            });
        },

        methods: {

            transform(value, key) {
                let newValue = '';
                if (key == 'address') {
                    newValue += '<ul>';
                    newValue += '<li>'
                    newValue += value.address_1 + ', '
                            + value.address_2 + ', '
                            + value.town + ', '
                            + value.county + ', '
                            + value.postcode
                            + '</li>';
                    newValue = newValue.replace('null,', '');
                    newValue += '</ul>';
                } else if(key == 'customer') {
                    newValue = value.firstname + ' ' + value.surname;

                } else if(key == 'value') {
                    newValue = '£'+value;

                } else if (key == 'stage') {
                    let className  = '';
                    if (value.name == 'Placed') {
                        className = 'blue';
                    } else if (value.name == 'Processed') {
                        className = 'orange';
                    } else if (value.name == 'Completed') {
                        className = 'green';
                    } else if (value.name == 'Delivered') {
                        className = 'purple';
                    }
                    newValue = '<span class="status ' + className + '">' + value.name + '</span>';
                } else {
                    newValue = value;
                }

                value = newValue;
                return value;
            },

            view(entry) {
                window.location = '/orders/' + entry.id;
            }

        }

    }
</script>
