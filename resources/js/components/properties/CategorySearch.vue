<template>
  <form method="GET" action="/property/search">
    <div class="form-row">
      <div class="form-group form-border search   col-md-3 mr-1">
        <label class="pl-4" for="Location-input">Location</label>
        <div class="input-group input-group-lg">
          <div class="input-group-prepend">
            <span
              class="input-group-text  border-0 text-muted fs-18"
              id="inputGroup-sizing-lg"
            >
              <i class="fas fa-map-marker-alt"></i>
            </span>
          </div>
          <input
            type="text"
            class="form-control ml-2 location-search"
            name="going_to"
            id="Location-input"
            placeholder="Where are you going"
            v-model="form.location"
          />
        </div>
      </div>

      <div
        class="form-group  form-border cursor-pointer search col-md-4 bmd-form-group"
      >
        <label class="pl-2 ml-4" for="flatpickr-input-f"
          >Check-in - Check-out</label
        >
        <date-range />
      </div>

      <div id="people-number" class="col-md-3  cursor-pointer">
        <guests />
      </div>
      <div class="col-md-1">
        <template v-if="!reload">
          <button
            type="button"
            @click.prevent="search()"
            class="btn btn-primary btn-block"
          >
            <i class="material-icons">search</i>
          </button>
        </template>
        <template v-if="reload">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="material-icons">search</i>
          </button>
        </template>
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
