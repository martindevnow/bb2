
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



Vue.component('quotes-calculator', require('./components/Quotes/Calculator.vue'));
Vue.component('customers-pet-selector', require('./components/Customers/PetSelector.vue'));
Vue.component('auth-login-form', require('./components/Auth/LoginForm.vue'));
Vue.component('auth-registration-form', require('./components/Auth/RegistrationForm.vue'));
Vue.component('details-collector', require('./components/Quotes/DetailsCollector.vue'));
Vue.component('quotes-checkout', require('./components/Quotes/Checkout.vue'));


Vue.component('cart-summary', require('./components/Cart/Summary.vue'));


Vue.component('admin-common-modal', require('./components/Admin/Common/Modal.vue'));
Vue.component('plan-builder', require('./components/PlanBuilder.vue'));
Vue.component('admin-meats-navigator', require('./components/Admin/Meats/Navigator.vue'));


Vue.component('admin-meals-select-box', require('./components/Admin/Meals/SelectBox.vue'));
Vue.component('admin-orders-dashboard', require('./components/Admin/Orders/Dashboard.vue'));

Vue.component('admin-payment-modal', require('./components/Admin/Orders/PaymentModal.vue'));
Vue.component('admin-payment-logger', require('./components/Admin/Orders/PaymentLogger.vue'));


Vue.component('example', require('./components/Example.vue'));
import { store } from './store/store';

const app = new Vue({
    el: '#content',
    store: store,
});
