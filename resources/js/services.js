require("./bootstrap");
import Vue from "vue";
import flatpickr from "flatpickr";
import store from "./store";

// require ('../../public/f/js/loadProducts.jquery.js')

const Persons = require("./components/persons/Persons.vue").default;
const RoomAvailable = require("./components/search/RoomAvailable.vue").default;
const BookIndex = require("./components/book/BookIndex.vue").default;

const app = new Vue({
  el: "#app",
  store,
  data: Window.user,
  components: {
    Persons,
    RoomAvailable,
    BookIndex,
  },
});

const f = flatpickr("#flatpickr-input-f", {
  mode: "range",
  minDate: "today",
  dateFormat: "Y-m-d",
});
