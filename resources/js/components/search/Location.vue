<template>
  <form method="GET" action="/property/search">
    <div class="form-row">
      <div
        class="form-group  form-border   search col-md-12 bmd-form-group m-0"
      >
        <div class="input-group input-group-lg">
          <div class="input-group-prepend">
            <span class="input-group-text" id="">
              <i class="fal fa-search"></i>
            </span>
          </div>
          <input
            class="form-control date-range cursor-pointer ml-2  text-size-1 location-search"
            placeholder="Search......"
            name="q"
            @input="getAutocomplete()"
            autocomplete="off"
            v-model="q"
          />
        </div>
      </div>
      <div
        v-if="open"
        class="auto-complete  rounded col-md-10 position-absolute"
      >
        <div class="auto-complete-dropdown-list">
          <div
            v-for="category in categories"
            :key="category.id"
            class="auto-complete-dropdown-items text-size-1   cursor-pointer mb-2"
          >
            <a class="text-gray" :href="'/properties/' + category.slug">{{
              category.name
            }}</a>
          </div>

          <div
            v-for="location in locations"
            :key="location.id"
            class="auto-complete-dropdown-items text-size-1 cursor-pointer mb-2"
          >
            <a class="text-gray" :href="'/properties/location/' + location.slug"
              >Properties in {{ location.name }}</a
            >
          </div>

          <div
            v-for="property in properties"
            :key="property.id"
            class="auto-complete-dropdown-items  text-size-1 cursor-pointer mb-2"
          >
            <a class="text-gray" :href="'/property/' + property.slug">{{
              property.name
            }}</a>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import axios from "axios";

export default {
  props: ["reload"],
  data() {
    return {
      guests: 0,
      categories: [],
      locations: [],
      properties: [],

      open: false,
      q: null,

      form: {
        room_quantity: [],
        selectedRooms: [],
      },
    };
  },
  computed: {
    ...mapGetters({
      locationSearch: "locationSearch",
    }),
  },
  created() {
    window.addEventListener("click", this.close);
  },
  beforeDestroy() {
    window.removeEventListener("click", this.close);
  },
  methods: {
    getAutocomplete() {
      axios
        .get("/auto-complete?q=" + this.q)
        .then((response) => {
          this.open = true;
          this.categories = response.data.categories;
          this.locations = response.data.locations;
          this.properties = response.data.properties;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    close(e) {
      if (!this.$el.contains(e.target)) {
        this.open = false;
      }
    },
  },
};
</script>
