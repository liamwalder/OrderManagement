
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};


window.Routes = {

    order: {
        list: '/api/orders',
        create: '/api/orders',
        single: '/api/order/{id}',
        edit:    '/api/order/{id}',
        destroy: '/api/order/{id}'
    },

    product: {
        list: '/api/products?l=',
        create: '/api/products',
        edit: '/api/product/{id}',
        destroy: '/api/product/{id}'
    },

    address: {
        create: '/api/addresses',
        edit: '/api/address/{id}',
        destroy: '/api/address/{id}'
    },

    customer: {
        single:  '/api/customer/{id}',
        list:    '/api/customers',
        create:  '/api/customers',
        edit:    '/api/customer/{id}',
        destroy: '/api/customer/{id}'
    }


};


window.moment = require('moment');

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
