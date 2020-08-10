import './bootstrap';
import Vue from 'vue';
import Vuetify from '@/js/vuetify.js';

// Route information for vue router
import Routes from '@/js/routes.js';

// Component file
import App from '@/js/views/App';

Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    router: Routes,
    vuetify: Vuetify,
    render: h => h(App),
});

export default app;
