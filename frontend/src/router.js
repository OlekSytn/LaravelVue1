import Vue from 'vue'
import VueRouter from 'vue-router'

// Home 
import ProductHome from "./components/frontend/ProductHome.vue"
import ProductDetails from "./components/frontend/ProductDetails.vue"

// Auth
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import ForgetPassword from './components/auth/ForgetPassword.vue'
import ResetPassword from './components/auth/ResetPassword.vue'
import Admin from './components/Dashboard/Admin.vue'

// category 
import CategoryList from './components/category/CategoryList.vue';
import AddCategory from './components/category/AddCategory.vue';
import EditCategory from './components/category/EditCategory.vue';

// product
import ListProduct from "./components/product/ListProduct.vue";
import AddProduct from "./components/product/AddProduct.vue";
import EditProduct from "./components/product/EditProduct.vue";


Vue.use(VueRouter)


const routes = [

    // home route
    { path: '/', component: ProductHome, name: 'home' },
    { path: '/product/:id/details', component: ProductDetails, name: 'product-details' },

    // authentication Route
    { path: '/login', component: Login, name: 'login' },
    { path: '/register', component: Register, name: 'register' },
    { path: '/forget-password', component: ForgetPassword, name:'forget-password' },
    { path: '/reset-password/:token', component: ResetPassword, name: 'reset-password' },
    { path: '/admin', component: Admin, name: 'admin' },

    // category route
    { path: '/categories', component: CategoryList, name: 'categories' },
    { path: '/categories/create', component: AddCategory, name: 'category_add' },
    { path: '/categories/:id/edit', component: EditCategory, name: 'category_edit' },

    // product route
    { path: '/products', component: ListProduct, name: 'products' },
    { path: '/add-products', component: AddProduct, name: 'add_product' },
    { path: '/product/:id/edit', component: EditProduct, name: 'edit_product' },


];
  

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

export default router;
