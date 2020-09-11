
require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('main-app', require('./components/MainApp').default);
Vue.component('chat-app', require('./components/ChatApp').default);

const app = new Vue({
    el: '#app',
});
