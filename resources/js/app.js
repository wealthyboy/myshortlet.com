
require('./bootstrap');
import Vue from 'vue'

import store from './store'
require ('../../public/f/js/plugins.js')
require ('../../public/f/js/main.min.js')
require ('../../public/f/js/loadProducts.jquery.js')


//Wishlist Code


// $(".btn-icon-group").on('click',function(){
//     let self = $(this)

//     if ( self.data('pid') == 0 ) { return; }
//     $.ajax({
//       url: "/api/wishlist",
//       type: "POST",
//       data: { "product_variation_id": self.data('pid') }
//     }).done(function(res){
//       self.find('.product-wishlist-icon-fillled').removeClass('d-none')
//       self.find('.product-wishlist-icon').addClass('d-none')
//       console.log(store)
//       store.commit('appendToWishlist',res.data)
//     }).catch(function(){
//       console.log(false)
//     })
// })





/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



const ProductsIndex = require('./components/products/Index.vue').default
const SideBar = require('./components/products/SideBar.vue').default
const ProductShow = require('./components/products/Show.vue').default
const TopCart = require('./components/cart/Top.vue').default
const CartSideBarMenu = require('./components/cart/CartSideBarMenu.vue').default
const NavIcon = require('./components/navigation/NavIcon.vue').default
const LoginModal = require('./components/auth/LoginModal.vue').default
const RegisterModal = require('./components/auth/RegisterModal.vue').default

const CartSummary = require('./components/cart/Cart.vue').default
const NewsLetter = require('./components/newsletter/Index.vue').default
const SignUp = require('./components/newsletter/SignUp.vue').default
const FavoriteIndex = require('./components/favorites/Index.vue').default
const Messages =  require('./components/message/index.vue').default
const Addresses =  require('./components/checkout/Addresses.vue').default
const ShipAddress =  require('./components/checkout/ShipAddress.vue').default
const Login =  require('./components/auth/LoginRegister.vue').default



const ForgotPassword =  require('./components/auth/ForgotPassword.vue').default
const ResetPassword =  require('./components/auth/ResetPassword.vue').default
const ChangePassword =  require('./components/auth/ChangePassword.vue').default
const Comments =  require('./components/blog/Comments.vue').default
const Images =  require('./components/images/Images.vue').default



let token = document.head.querySelector('meta[name="csrf-token"]');
Window.token = token.content

Vue.filter('priceFormat',function(value){
    return new Intl.NumberFormat().format(value);
});

const app = new Vue({
    el: '#app',
    store, 
    data:Window.user,
    components:{
        TopCart,
        CartSideBarMenu,
        ProductsIndex,
        SideBar,
        ProductShow,
        NavIcon,
        LoginModal,
        RegisterModal,
        CartSummary,
        NewsLetter,
        FavoriteIndex,
        Messages,
        Addresses,
        ShipAddress,
        ForgotPassword,
        ResetPassword,
        ChangePassword,
        Comments,
        SignUp,
        Images,
        Login
        
    }   
});

