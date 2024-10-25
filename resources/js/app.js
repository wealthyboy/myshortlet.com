require("./bootstrap");
import Vue from "vue";

import store from "./store";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
*/

const SearchBar = require("./components/search/Index.vue").default;
//const NewsLetter = require("./components/newsletter/Index.vue").default;
const SignUp = require("./components/newsletter/SignUp.vue").default;
const FavoriteIndex = require("./components/favorites/Index.vue").default;
const Login = require("./components/auth/LoginRegister.vue").default;
const ForgotPassword = require("./components/auth/ForgotPassword.vue").default;
const ResetPassword = require("./components/auth/ResetPassword.vue").default;
const ChangePassword = require("./components/auth/ChangePassword.vue").default;
const Comments = require("./components/blog/Comments.vue").default;
const Table = require("./components/table/Table").default;
const Account = require("./components/account/Account").default;
let token = document.head.querySelector('meta[name="csrf-token"]');
Window.token = token.content;

Vue.filter("priceFormat", function (value) {
  return new Intl.NumberFormat().format(value);
});

const app = new Vue({
  el: "#app",
  store,
  data: Window.user,
  components: {
    SearchBar,
    LoginModal,
    RegisterModal,
    FavoriteIndex,
    ForgotPassword,
    ResetPassword,
    ChangePassword,
    Comments,
    SignUp,
    Login,
    Account,
    Table
  },
});
