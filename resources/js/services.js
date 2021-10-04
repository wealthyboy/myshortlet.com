require("./bootstrap");
import Vue from "vue";
import flatpickr from "flatpickr";
import validate from "jquery-validation";

import store from "./store";

require("./scripts.js");

const Persons = require("./components/persons/Persons.vue").default;
const RoomAvailable = require("./components/search/RoomAvailable.vue").default;
const BookIndex = require("./components/book/BookIndex.vue").default;
const AddProperty = require("./components/properties/AddProperty.vue").default;
const CategorySearch = require("./components/properties/CategorySearch.vue")
  .default;

const ProductsIndex = require("./components/properties/Index.vue").default;
const FilterSearch = require("./components/properties/Filter.vue").default;
const PropertiesCount = require("./components/properties/PropertyCount.vue")
  .default;

const Location = require("./components/search/Location.vue").default;

$().ready(function() {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
});

//console.log(intlTelInput());

const app = new Vue({
  el: "#app",
  store,
  data: Window.user,
  components: {
    Persons,
    RoomAvailable,
    BookIndex,
    AddProperty,
    Location,
    ProductsIndex,
    FilterSearch,
    PropertiesCount,
    CategorySearch,
  },
});

const f = flatpickr("#flatpickr-input-f", {
  mode: "range",
  minDate: "today",
  dateFormat: "Y-m-d",
  showMonths: 2,
});

// f.config.onChange.push(function(selectedDates, dateStr, instance) {
//   console.log(dateStr);
// });
