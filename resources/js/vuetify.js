import Vue from 'vue'
import Vuetify, {
    VApp,
    VAppBar,
    VNavigationDrawer,
    VToolbar,
    VContainer,
    VContent
} from 'vuetify';

Vue.use(Vuetify);

const opts = new Vuetify ({
    components: {
        VApp, 
        VAppBar, 
        VNavigationDrawer, 
        VToolbar, 
        VContainer, 
        VContent
    }
})

export default opts;