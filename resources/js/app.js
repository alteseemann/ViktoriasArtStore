/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./burger-menu');

window.Vue = require('vue').default;


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('product', require('./components/product.vue').default);
Vue.component('catalog', require('./components/catalog.vue').default);
Vue.component('cart', require('./components/cart.vue').default);
Vue.component('cart_item', require('./components/cart-item.vue').default);
Vue.component('cart_vidget', require('./components/cart-viget.vue').default);
Vue.component('popup', require('./components/Popup.vue').default);

const app = new Vue({
    el: '#app',
});
