<template>
  <div>


    sdsdd
    <div v-if="!propertyLoading && properties.length">
      <div class="col-md-12 category-search ml-auto mr-auto mt-4">

      </div>

      <div class="form-row">
        <div class="form-group category-search ml-1 mr-sm-1  form-border cursor-pointer search col-md-4 bmd-form-grup">
          <label class="pl-2  bmd-label-static  checkin mb-0 pl-1" for="flatpickr-input-f">Check-in - Check-out</label>
          <date-picker />
        </div>
        <div id="people-number" class="col-md-4 cursor-pointer ">
          <guests />
        </div>
        <div class="col-md-3  mb-lg-0 mt-lg-0 mt-sm-3 mb-sm-3  ml-1 mr-1 check-availablility">
          <button type="button" @click.prevent="checkAvailabity()"
            class="btn btn-primary btn-block m-auto bold check-availablility-button">
            <i class="material-icons"></i> Check availablity
          </button>
        </div>
      </div>

      <div v-for="property in properties" :key="property.id"
        class="bg-white mb-2 rounded position-relative border-radius loaded-apartments">
        <div class="row no-gutters">
          <div class="col-md-3 col-12 position-relative">
            <div>
              <a target="_blank" :href="property.link">
                <img :src="property.image_m" class="img  img-fluid" />
              </a>
              <div class="fav-icon position-absolute">
                <saved :property="property" />
              </div>
            </div>
          </div>
          <div class="col-md-9 position-relative  pl-3">
            <h6 class="card-category text-gold">
              {{ property.categories }}
            </h6>
            <div class="d-flex  justify-content-between">
              <div>
                <a target="_blank" class="bold text-size-1-big" :href="property.link">{{ property.name }}</a>
                <div class="d">
                  <small><a :href="property.link" class="p-0">{{ property.city }}</a>, <a href="">{{ property.state
                  }}</a></small>
                </div>
                <div class="mb-5">
                  <div v-if="property.facilities.length" class="facilities text-gold text-size-1">
                    <span :key="facility.id" v-for="facility in property.facilities">{{ facility.name }}.
                    </span>
                  </div>

                  <div v-if="property.type == 'single'" class="guests-section text-size-1 ">
                    <span>{{ property.guests }} guests</span>
                    <span aria-hidden="true"> · </span>
                    <span>{{ property.rooms }} bedroom</span>
                    <span aria-hidden="true"> · </span>
                    <span>{{ property.baths }} baths</span>
                  </div>

                  <div class="text-size-1 text-gray" v-if="property.is_refundable">
                    Fully Refundable
                  </div>
                  <div v-if="property.free_services.length" class="d-inline-flex mr-2 text-size-1 ">
                    <div v-for="free_service in property.free_services" :key="free_service.id"
                      class="free-services mr-2 text-size-1">
                      {{ free_service.name }} included
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end">
              <div class="reviews-section"></div>
              <div class="text-right mr-4">
                <div class="d-inline-flex">
                  <template v-if="property.default_discounted_price">
                    <div class="sale-price bold mr-3 text-gold">
                      {{ property.currency
                      }}{{ property.converted_price | priceFormat }}
                    </div>
                    <div class="price bold">
                      {{ property.currency }}
                      {{ property.default_discounted_price | priceFormat }}
                    </div>
                  </template>
                  <template v-else>
                    <div class="price bold">
                      {{ property.currency
                      }}{{ property.converted_price | priceFormat }}
                    </div>
                  </template>
                </div>
                <div class="text-size-2">
                  {{ property.price_mode }} per night
                </div>
                <div class="text-size-1 text-success" v-if="property.is_refundable">
                  Fully Refundable
                </div>
                <a v-if="property.mode == 'shortlet'" target="_blank" :href="property.link"
                  class="btn btn-primary btn-round d-none bold d-lg-block d-xl-block">
                  Check Availability
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="pagination" v-if="!propertyLoading && properties.length && next_page_url"
      class="d-flex justify-content-center">
      <a :href="next_page_url" id="load_more" @click.prevent="loadMore($event)" class="btn btn-primary  mt-4 mb-2">
        <span class="spinner-grow spinner-grow-md d-none"></span>
        Load More ...
        {{ properties.total }}
      </a>
    </div>

    <div v-if="!propertyLoading && !properties.length" class="no-properties-found">
      <div class="text-center">
        <div><i class="fas fa-home fa-5x"></i></div>
        <div>We could not match any apartments to your search</div>
      </div>
    </div>
    <loaders />
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Pagination from "../pagination/Pagination.vue";
import Loaders from "./Loaders.vue";
import Saved from "./Saved.vue";
import Guests from "./Guests.vue";
import DatePicker from "./Date";


import CategorySearch from "./CategorySearch.vue";


export default {
  name: "Index",
  props: {
    user: Object,
    propertys: Array,
    next_page: Array,
    total: Number,
  },
  components: {
    Pagination,
    Loaders,
    Saved,
    CategorySearch,
    Guests,
    DatePicker
  },
  data() {
    return {
      meta: {},
      has_filters: 0,
      full_width: false,
      loading: false,
      search: false,
      propes: [],
      guests: 0,
      form: {
        room_quantity: [],
        selectedRooms: [],
        location: this.$root.request.going_to,
      },
    };
  },
  computed: {
    ...mapGetters({
      properties: "properties",
      propertyLoading: "propertyLoading",
      links: "links",
      next_page_url: "next_page_url",

    }),
  },

  mounted() {
    this.$store.commit("setPropertyLoading", true);
    let time = new Date().getTime();
    console.log(true);
    setTimeout(() => {
      document.getElementById("ap-loaders").classList.add('d-none')
      document.getElementById("category-loader").classList.add('d-none')
      this.$store.commit("setProperties", this.propertys);
      this.$store.commit("setMeta", this.total);
      this.$store.commit("setPropertyLoading", false);
    }, 1000);



    this.$store.commit("setNextPageUrl", this.next_page[0]);
  },
  methods: {
    ...mapActions({
      getProperties: "getProperties",
      saveProperty: "saveProperty",
    }),
    favorite: function (e, property_id) {
      this.saveProperty({
        property_id: property_id,
      }).then((res) => { });
    },
    loadMore(e) {
      let t = new Date().getTime();
      let href = e.target.getAttribute("href");
      this.getProperties(href + "&timestamp=${new Date().getTime()}").then(
        (r) => { }
      );
    },
    build() {
      let locationSearch = [];
      document.querySelectorAll(".location-search").forEach((e, i) => {
        locationSearch.push(e.name + "=" + e.value);
      });

      window.history.pushState("", "Title", "/property/search");

      let url = window.history.pushState(
        {},
        "",
        "?" + locationSearch.join("&")
      );

      this.$store.commit("setLocationSearch", locationSearch);
    },
    checkAvailabity: function () {
      this.build();

      this.getProperties(window.location);
    },
  },
};
</script>
