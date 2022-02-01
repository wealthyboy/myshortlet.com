<template>
  <form id="collections" action="">
    <div class="text-left pl-3">
      <div class="text-capitalize pb-2 pt-3 bold">Your Budget</div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="0-50000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">less than - 50k</span>
          </label>
        </div>
      </div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="50000-150000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">50k - 150k</span>
          </label>
        </div>
      </div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="150000-250000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">150k - 250k</span>
          </label>
        </div>
      </div>

      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="250000-10000000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">250k - 10m</span>
          </label>
        </div>
      </div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="10000000-50000000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">10m - 50m</span>
          </label>
        </div>
      </div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="50000000-250000000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">50m - 250m</span>
          </label>
        </div>
      </div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="250000000-10000000000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">Above - 250m</span>
          </label>
        </div>
      </div>

      <template v-if="attributes">
        <div v-for="(map, k) in attributes" :key="k">
          <div class="text-capitalize pb-2 bold">
            {{ k }}
          </div>

          <div v-for="(children, index) in map" :key="children.id" class="mb-2">
            <div class="checkbox">
              <label id="box50" class="checkbox-label">
                <input
                  for="box50"
                  :name="k + '[]'"
                  :value="children.slug"
                  class="filter-property"
                  type="checkbox"
                  @change="activateFilter()"
                />
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">{{
                  children.name
                }}</span>
              </label>
            </div>
          </div>
        </div>
      </template>

      <template v-if="locations.length">
        <div class="text-capitalize pb-2 bold">Locations</div>
        <div v-for="location in locations" :key="location.id" class="mb-2">
          <div class="checkbox">
            <label id="box50" class="checkbox-label">
              <input
                for="box50"
                name="locations[]"
                :value="location.slug"
                class="filter-property"
                type="checkbox"
                @change="activateFilter()"
              />
              <span class="checkbox-custom rectangular"></span>
              <span class="checkbox-label-text mt-1">{{ location.name }}</span>
            </label>
          </div>
        </div>
      </template>
    </div>
  </form>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  props: {
    attrs: Object,
    locations: Array,
    category: Object,
  },
  data() {
    return {
      isOpen: false,
      filters: [],
      categories: [],
      qS: [],
      filter: true,
      t: null,
    };
  },
  computed: {
    ...mapGetters({
      attributes: "attributes",
      propertyLoading: "propertyLoading",
      locationSearch: "locationSearch",
    }),
  },
  created() {
    this.$store.commit("setAttributes", this.attrs);
  },

  methods: {
    ...mapActions({
      getProperties: "getProperties",
      lSearch: "lSearch",
    }),
    activateFilter() {
      var inputs = document.querySelectorAll("input.filter-property:checked");
      var checkboxesChecked = [];
      for (var i = 0; i < inputs.length; i++) {}
      for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].checked) {
          checkboxesChecked.push(inputs[i].name + "=" + inputs[i].value);
        }
      }

      let uri = new URL(window.location);
      if (uri.pathname == "/property/search") {
        this.lSearch();
      }

      if (this.locationSearch.length) {
        this.locationSearch.forEach((e) => {
          checkboxesChecked.push(e);
        });
      }

      let sort_by = document.querySelector("#sort_by");
      if (sort_by && sort_by.value) {
        checkboxesChecked.push(sort_by.name + "=" + sort_by.value);
      }

      this.buildUrl(checkboxesChecked);
      this.filterProperty(window.location);
    },
    buildUrl(qs) {
      window.history.pushState({}, "", "?" + qs.join("&"));
    },
    filterProperty(url) {
      let t = new Date().getTime();
      this.getProperties(url + "&timestamp=" + t);
    },
  },
};
</script>
