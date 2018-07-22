require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;
window.VueAxios = require('vue-axios').default;
window.Axios = require('axios').default;

//Registering modules
Vue.use(VueRouter, VueAxios, axios);

let AppLayout = require('./components/App.vue');

const ListComposition = Vue.component('list-composition', require('./components/ListComposition.vue'));
const AddComposition = Vue.component('add-composition', require('./components/AddComposition.vue'));
const EditComposition = Vue.component('edit-composition', require('./components/EditComposition.vue'));
const DeleteComposition = Vue.component('delete-composition', require('./components/DeleteComposition.vue'));
const ViewComposition = Vue.component('view-composition', require('./components/ViewComposition.vue'));

const routes = 
    [{
        name: 'ListComposition',
        path: '/',
        component: ListComposition
    },
    {
        name: 'AddComposition',
        path: '/add-composition',
        component: AddComposition
    },
    {
        name: 'EditComposition',
        path: '/edit-composition',
        component: EditComposition
    },{
        name: 'DeleteComposition',
        path: '/delete-composition',
        component: DeleteComposition
    },{
        name: 'ViewComposition',
        path: '/view/:id',
        component: ViewComposition
    }
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

new Vue(
    Vue.util.extend(
        { router},
        AppLayout
    )
).$mount('#app');
