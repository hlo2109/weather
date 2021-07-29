/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import axios from 'axios';
import Vue from 'vue'

window.Vue = Vue;

import { Lang } from 'laravel-vue-lang';
import Notifications from 'vue-notification'

Vue.use(Lang, {
	locale: 'en',
	fallback: 'en'
});
Vue.use(Notifications)


Vue.component('load-map', require('./components/LoadMap.vue').default);
Vue.component('seach-city', require('./components/Search.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data(){
        return{
           activeMenu:false,
           addCity:null
        }
    }, 
    methods:{
        selectity(city){
            this.addCity = city;
            this.activeMenu = !this.activeMenu;
        }
    }
});
