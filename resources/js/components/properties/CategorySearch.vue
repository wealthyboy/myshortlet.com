<template>
  <form method="GET" action="/property/search">
    <div class="form-row">
      <div
        class="form-group  form-border cursor-pointer search col-md-5 bmd-form-group"
      >
        <label class="pl-2 ml-4" for="flatpickr-input-f"
          >Check-in - Check-out</label
        >
        <date-range />
      </div>

      <div id="people-number" class="col-md-5  cursor-pointer p-0">
        <guests />
      </div>
      <div class="col-md-2  check-availablility">
        <button
          type="button"
          @click.prevent="search()"
          class="btn btn-primary btn-block m-auto  bold check-availablility-button"
        >
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
    search: function() {
      this.build();

      this.getProperties(window.location);
    },
  },
};
</script>
