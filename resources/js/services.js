require("./bootstrap");
import Vue from "vue";
import flatpickr from "flatpickr";
import validate from "jquery-validation";
window.flexslider = require("flexslider");

import store from "./store";

require("./scripts.js");

const RoomAvailable = require("./components/search/RoomAvailable.vue").default;
const BookIndex = require("./components/book/BookIndex.vue").default;
const AddProperty = require("./components/properties/AddProperty.vue").default;
const CategorySearch = require("./components/properties/CategorySearch.vue")
  .default;

const ProductsIndex = require("./components/properties/Index.vue").default;
const FilterSearch = require("./components/properties/Filter.vue").default;
const PropertiesCount = require("./components/properties/PropertyCount.vue")
  .default;

const SingleApartment = require("./components/properties/SingleApartment.vue")
  .default;

const MultipleApartments = require("./components/properties/MultipleApartments.vue")
  .default;

const Saved = require("./components/properties/Saved.vue").default;

const Location = require("./components/search/Location.vue").default;

$().ready(function() {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
});

//console.log(intlTelInput());

Vue.prototype.$eventBus = new Vue(); // Global event bus

const app = new Vue({
  el: "#app",
  store,
  data: Window.user,
  components: {
    RoomAvailable,
    BookIndex,
    AddProperty,
    Location,
    ProductsIndex,
    FilterSearch,
    PropertiesCount,
    CategorySearch,
    SingleApartment,
    MultipleApartments,
    Saved,
  },
});

jQuery(function() {
  $(".flexslider").flexslider({
    animation: "slide",
  });
});

// f.config.onChange.push(function(selectedDates, dateStr, instance) {
//   console.log(dateStr);
// });
