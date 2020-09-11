
require('./bootstrap');

window.Vue = require('vue');
// vuex configure
    import Vuex from 'vuex'
    Vue.use(Vuex)
    import storeVuex from './store/index'
    const store = new Vuex.Store(storeVuex)
// end vuex configure

//Start Moment
import moment from 'moment'
window.moment =moment
//End Moment

//start chat scroll
    import VueChatScroll from 'vue-chat-scroll'
    Vue.use(VueChatScroll)
//end chat scroll
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('main-app', require('./components/MainApp').default);
Vue.component('chat-app', require('./components/ChatApp').default);

const app = new Vue({
    el: '#app',
    store,
});
