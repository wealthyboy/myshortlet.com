
require('./bootstrap');
import Vue from 'vue'
import flatpickr from "flatpickr";


require ('../../public/f/js/loadProducts.jquery.js')
flatpickr("#flatpickr-input",{
    mode: "range",
    minDate: "today",
    dateFormat: "Y-m-d",
    disable: [
        function(date) {
            // disable every multiple of 8
            return !(date.getDate() % 8);
        }
    ]
})





/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */





// let token = document.head.querySelector('meta[name="csrf-token"]');
// Window.token = token.content

Vue.filter('priceFormat',function(value){
    return new Intl.NumberFormat().format(value);
});



