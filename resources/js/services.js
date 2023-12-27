
require("./bootstrap");
import Vue from "vue";

import validate from "jquery-validation";

window.flexslider = require("flexslider");
require("owl.carousel");

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

const PropertyCreate = require("./components/properties/Create.vue").default;

const Saved = require("./components/properties/Saved.vue").default;

const Location = require("./components/search/Location.vue").default;

$().ready(function () {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const leftBox = document.getElementById('intro-box');
  // const rightBox = document.getElementById('rightBox');

  // Set up the Intersection Observer for the left box
  const leftObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Add a CSS class to trigger the animation
        entry.target.classList.add('animate__animated animate__bounc');
        // Unobserve the target to stop further observations
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 }); // Adjust the threshold based on your needs

  // Start observing the left box
  leftObserver.observe(leftBox);

  // // Set up the Intersection Observer for the right box
  // const rightObserver = new IntersectionObserver((entries, observer) => {
  //   entries.forEach(entry => {
  //     if (entry.isIntersecting) {
  //       // Add a CSS class to trigger the animation
  //       entry.target.classList.add('animate-right');
  //       // Unobserve the target to stop further observations
  //       observer.unobserve(entry.target);
  //     }
  //   });
  // }, { threshold: 0.5 }); // Adjust the threshold based on your needs

  // // Start observing the right box
  // rightObserver.observe(rightBox);
});




//console.log(intlTelInput());

Vue.filter("priceFormat", function (value) {
  return new Intl.NumberFormat().format(value);
});

console.log(Window.user)

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
    PropertyCreate,
  },
});

(function ($) {
  "use strict";

  jQuery(function () {
    $(".flexslider").flexslider({
      animation: "slide",
    });

    $(".home-flexslider").flexslider({
      animation: "slide",
    });

    jQuery(function () {
      $(".test-carousel").owlCarousel({
        margin: 10,
        nav: true,
        dots: false,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 1,
          },
          1000: {
            items: 1,
          },
        },
      });
    });

    $(".cities-carousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      dots: true,
      center: true,
      navText: [
        '<div class="nav-btn prev-slide"><svg width="31" height="50" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg"><path d="M19.9 40L1.3 20 19.9 0" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
        '<div class="nav-btn next-slide"><svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg"><path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        1000: {
          items: 2,
        },
      },
    });

    $(".main-slider").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      dots: true,
      animateIn: "fadeIn",
      animateOut: "fadeOut",
      navText: [
        '<div class="nav-btn prev-slide"><svg width="31" height="50" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg"><path d="M19.9 40L1.3 20 19.9 0" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
        '<div class="nav-btn next-slide"><svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg"><path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        1000: {
          items: 1,
        },
      },
    });
  });
})(jQuery);
