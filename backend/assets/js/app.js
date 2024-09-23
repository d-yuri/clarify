import Vue from 'vue';
import App from '../components/App.vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
new Vue({
    render: h => h(App),
}).$mount('#app');

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)