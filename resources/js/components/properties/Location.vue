<template>
  <form method="GET" action="/property/search">
    <div class="form-row">
      <div
        class="form-group  form-border cursor-pointer search col-md-5 bmd-form-group"
      >
        <label class="pl-2 ml-4" for="flatpickr-input-f"
          >Check-in - Check-out</label
        >
        <div class="input-group input-group-lg">
          <div class="input-group-prepend">
            <span
              class="input-group-text  border-0 text-muted fs-18"
              id="inputGroup-sizing-lg"
            >
              <i class="fal fa-calendar-week"></i>
            </span>
          </div>
          <input
            class="form-control date-range cursor-pointer ml-2 location-search"
            placeholder="Check in - Check out"
            name="check_in_checkout"
          />
        </div>
      </div>

      <div class="col-md-2">
        <button
          type="button"
          @click.prevent="search()"
          class="btn btn-primary btn-block"
        >
          <i class="material-icons"></i>
        </button>
      </div>
    </div>
  </form>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

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
