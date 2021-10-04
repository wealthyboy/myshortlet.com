<template>
  <form id="collections" action="">
    <div class="text-left pl-3">
      <div class="text-capitalize pb-2 pt-3">Your Budget</div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="0-200000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">200,000</span>
          </label>
        </div>
      </div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="200000-500000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">200,000k - 500,000k</span>
          </label>
        </div>
      </div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="500000-1000000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">500,000k - 1,000,000</span>
          </label>
        </div>
      </div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="prices[]"
              value="1000000-10000000"
              class="filter-property"
              type="checkbox"
              @change="activateFilter()"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">1,000,000 - 10,000,000</span>
          </label>
        </div>
      </div>

      <template v-if="attributes">
        <div v-for="(map, k) in attributes" :key="k">
          <div class="text-capitalize pb-2">
            {{ k }}
          </div>

          <div v-for="(children, index) in map" :key="children.id" class="mb-2">
            <div class="checkbox">
              <label id="box50" class="checkbox-label">
                <input
                  for="box50"
                  :name="children.slug + '[]'"
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

      <div class="text-capitalize pb-2">Cities</div>
      <div class="mb-2">
        <div class="checkbox">
          <label id="box50" class="checkbox-label">
            <input
              for="box50"
              name="cities[]"
              value=""
              class="filter-property"
              type="checkbox"
            />
            <span class="checkbox-custom rectangular"></span>
            <span class="checkbox-label-text mt-1">w</span>
          </label>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  props: {
    attrs: Object,
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
      properties: "properties",
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

      this.getProperties(url + "&timestamp=${new Date().getTime()}");
    },
  },
};
</script>
