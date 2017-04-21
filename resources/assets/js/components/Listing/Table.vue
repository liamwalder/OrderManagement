<style>
    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: 0.66;
    }

    .arrow.asc {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-bottom: 4px solid black;
    }

    .arrow.dsc {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid black;
    }
</style>

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
                            <button class="btn btn-sm orange" @click="edit(entry)"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
                            <button class="btn btn-sm red" @click="remove(entry)"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

//    import eventHub from '../../src/EventHub.js';

    module.exports = {

        props: {
            columns: Array,
            apiUrl: String,
            deletionModalId: String
        },

        data: function () {
            var sortOrders = {};
            this.columns.forEach(function (key) {
                sortOrders[key] = 0;
            });
            return {
                data: [],
                sortKey: '',
                pagination: [],
                searchTerm: '',
                lastApiUrlCalled: '',
                sortOrders: sortOrders
            }
        },

        created: function() {
            this.getData(this.apiUrl);
        },

        methods: {

            search: function(searchTermValue) {
                var self = this;
                var gotAllData = false;
                if (searchTermValue.length > 2) {
                    self.searchTerm = searchTermValue;
                    let apiUrl = self.apiUrl;
                    apiUrl += '&search=' + searchTermValue;
                    self.getData(apiUrl);
                    gotAllData = false;
                } else {
                    if (gotAllData == false) {
                        self.getData(self.apiUrl);
                        gotAllData = true;
                    }
                    self.searchTerm = '';
                }
                self.columns.forEach(function (columnKey) {
                    self.sortOrders[columnKey] = 0;
                });
                self.sortKey = '';
            },

            getData: function (apiUrl) {
                let vm = this;
                axios.get(apiUrl)
                        .then(function (response) {
                            vm.data = response.data.entities.items;
                            vm.pagination = response.data.entities.pagination.meta;
                            vm.lastApiUrlCalled = apiUrl;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            },

            sortBy: function (key) {
                var self = this;
                this.columns.forEach(function (columnKey) {
                    if (columnKey != key) {
                        self.sortOrders[columnKey] = 0;
                    }
                });

                /**
                 * 0 = No sorted
                 * 1 = Descending
                 * 2 = Ascending
                 *
                 * If the key is 0 or 1, add 1 to it.
                 * If is equal to 2 send back to no sorting
                 */
                let updatedKeyValue = this.sortOrders[key];
                if (updatedKeyValue < 2) {
                    updatedKeyValue++;
                    this.sortKey = key;
                } else if (updatedKeyValue == 2) {
                    updatedKeyValue = 0;
                    this.sortKey = '';
                }

                this.sortOrders[key] = updatedKeyValue;

                /**
                 * 0 = No sorting
                 * 1 = Descending
                 * 2 = Ascending
                 */
                let apiUrl = this.apiUrl;
                if (this.sortOrders[key] !== 0) {
                    let direction = 'DESC';
                    if (this.sortOrders[key] == 2) {
                        direction = 'ASC';
                    }
                    apiUrl += '&order_by=' + key + '&direction=' + direction;
                }

                if (this.searchTerm.length > 2) {
                    apiUrl += '&search=' + this.searchTerm;
                }

                this.getData(apiUrl);
            },

            /**
             * Handle the change of the per page dropdown
             */
            perPageChange: function (perPage) {
                this.pagination.per_page = perPage;
                let apiUrl = this.lastApiUrlCalled;
                apiUrl += '&page=1&per-page=' + perPage;
                this.getData(apiUrl);
            },

            /**
             * Handle pressing next page
             */
            nextPage: function () {
                if (this.pagination.showing != this.pagination.total) {
                    let perPage = this.pagination.per_page;
                    let page = this.pagination.page;
                    page++;
                    let apiUrl = this.lastApiUrlCalled;
                    apiUrl += '&page=' + page + '&per-page=' + perPage;
                    this.getData(apiUrl);
                }
            },

            /**
             * Handle pressing prev page
             */
            prevPage: function () {
                if (this.pagination.page > 1) {
                    let perPage = this.pagination.per_page;
                    let page = this.pagination.page;
                    page--;
                    let apiUrl = this.lastApiUrlCalled;
                    apiUrl += '&page=' + page + '&per-page=' + perPage;
                    this.getData(apiUrl);
                }
            },

            remove: function (entry) {
                var modal = $(this.deletionModalId);
                var inputs = $(modal).find(':input');
                $.each(inputs, function(key, input) {
                    var inputName = $(input).attr('name');
                    if (entry[inputName]) {
                        $(input).val(entry[inputName]);
                    }
                });
                modal.modal('show');
            }
        }
    }
</script>