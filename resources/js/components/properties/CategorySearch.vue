<template>
  <form method="GET" action="/property/search" class="form-row">
    <div class="d-flex justify-content-between ">
      <div class="form-group ml-1 mr-sm-1 form-border cursor-pointer search col-md-4 bmd-form-group mb-sm-2 mb-md-0">
        <label class=" pl-2 ml-4" for="flatpickr-input-f">Check-in - Check-out</label>
        <date-range />
      </div>

      <div id="people-number" class="w-100 ml-2 col-md-4 cursor-pointer p-0  px-sm-0 px-md-1">
        <guests />
      </div>
      <div class="w-25 ml-2 col- check-availablility mb-sm-3 mb-md-0  mt-sm-2 mt-md-0">
        <button type=" button" @click.prevent="search()"
          class="btn btn-primary btn-block m-auto rounded  bold check-availablility-button">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

import Pickr from "vue-flatpickr-component";
import Guests from "./Guests.vue";
import DateRange from "./Date.vue";

export default {
  props: ["reload"],
  data() {
    return {
      guests: 0,
      form: {
        room_quantity: [],
        selectedRooms: [],
        location: this.$root.request.going_to,
      },
    };
  },
  components: {
    Pickr,
    Guests,
    DateRange,
  },
  computed: {
    ...mapGetters({
      locationSearch: "locationSearch",
    }),
  },
  mounted() {
    //this.build();
  },
  methods: {
    ...mapActions({
      getProperties: "getProperties",
    }),
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
    search: function () {
      this.build();

      this.getProperties(window.location);
    },
  },
};
</script>
