require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { Button,Layout,Space,Menu,Icon,Form,Select,Input,Col,Row,Checkbox,Pagination,message,Tabs,Radio,Modal,Table,Tag,Divider,DatePicker} from 'ant-design-vue';

import mixin from './mixin';
Vue.mixin(mixin);
require('ant-design-vue/dist/antd.css');
Vue.config.productionTip = false;
Vue.use (Button);
Vue.use (Layout);
Vue.use (Space);
Vue.use (Menu);
Vue.use (Icon);
Vue.use (Form);
Vue.use (Select);
Vue.use (Input);
Vue.use (Tabs);
Vue.use (Col);
Vue.use (Row);
Vue.use (Row);
Vue.use (Modal);
Vue.use (Table);
Vue.use (Tag);
Vue.use (DatePicker);
Vue.use (Divider);
Vue.use (Checkbox);
Vue.use (Pagination);
Vue.prototype.$message = message;

Vue.use(VueRouter);

Vue.component('login', require('./components/Login.vue').default);
Vue.component('config', require('./components/admin/Config.vue').default);
Vue.component('resetpass', require('./components/ResetPassword.vue').default);
Vue.component('newpassword', require('./components/NewPassword.vue').default);
Vue.component('statistic', require('./components/views/Statistic.vue').default);

import App from './components/App.vue'
import Statistic from './components/views/Statistic.vue'
import customer from './components/views/customer.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'statistic',
            component: Statistic
        },
        {
            path: 'khach-hang',
            name: 'statistic',
            component: Statistic
        },
        {
            path: 'them-khach-hang',
            name: 'customer',
            component: customer
        }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});