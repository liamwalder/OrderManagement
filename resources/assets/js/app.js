
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./frontend');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('customer-search-box', require('./components/Shared/CustomerSearchBox.vue'));
Vue.component('product-search-box', require('./components/Shared/ProductSearchBox.vue'));
Vue.component('errors', require('./components/Shared/Errors.vue'));
Vue.component('search', require('./components/Shared/Search.vue'));
Vue.component('pagination', require('./components/Listing/Pagination.vue'));
Vue.component('statistic-panel', require('./components/Dashboard/StatisticPanel.vue'));
Vue.component('order-statistic-widget', require('./components/Dashboard/OrderStatisticWidget.vue'));

/**
 * Order
 */
Vue.component('create-order-screen', require('./components/Orders/Create.vue'));
Vue.component('edit-order-screen', require('./components/Orders/Edit.vue'));
Vue.component('order-delete-modal', require('./components/Orders/Delete.vue'));

/**
 * Orders
 */
Vue.component('order-single', require('./components/Orders/Single.vue'));
Vue.component('order-table-listing', require('./components/Orders/Listing.vue'));

/**
 * Addresses
 */
Vue.component('address-create-modal', require('./components/Address/Create/Modal.vue'));
Vue.component('address-create-form', require('./components/Address/Create/Form.vue'));
Vue.component('address-edit-modal', require('./components/Address/Edit/Modal.vue'));
Vue.component('address-edit-form', require('./components/Address/Edit/Form.vue'));
Vue.component('address-delete-modal', require('./components/Address/Delete/Modal.vue'));

/**
 * Products
 */
Vue.component('product-table-listing', require('./components/Products/Listing.vue'));
Vue.component('product-create-modal', require('./components/Products/Create/Modal.vue'));
Vue.component('product-create-form', require('./components/Products/Create/Form.vue'));
Vue.component('product-edit-modal', require('./components/Products/Edit/Modal.vue'));
Vue.component('product-edit-form', require('./components/Products/Edit/Form.vue'));
Vue.component('product-delete-modal', require('./components/Products/Delete/Modal.vue'));

/**
 * Customers
 */
Vue.component('customer-table-listing', require('./components/Customers/Listing.vue'));
Vue.component('customer-create-modal', require('./components/Customers/Create/Modal.vue'));
Vue.component('customer-create-form', require('./components/Customers/Create/Form.vue'));
Vue.component('customer-edit-modal', require('./components/Customers/Edit/Modal.vue'));
Vue.component('customer-edit-form', require('./components/Customers/Edit/Form.vue'));
Vue.component('customer-delete-modal', require('./components/Customers/Delete/Modal.vue'));

Vue.filter('formatDateTimeUK', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY hh:mm')
    }
});

Vue.filter('prettify', function (str) {
    str = str.replace('_', ' ');
    return str.charAt(0).toUpperCase() + str.slice(1)
});

const app = new Vue({
    el: '#page-wrapper'
});
