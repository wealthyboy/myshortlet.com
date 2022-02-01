<template>
  <div
    v-if="properties.length"
    class="col-12 d-flex  mb-3 justify-content-between"
  >
    <div class="bold text-gray">{{ meta.total }} properties found</div>
    <div class="d-flex justify-content-md-end align-items-center">
      <div class="input-group border rounded  w-auto bg-white mr-3">
        <label
          class="input-group-text bg-transparent border-0   pr-1 pl-3"
          for="inputGroupSelect01"
          ><i class="fas fa-align-left fs-16 pr-2"></i>Sortby:</label
        >
        <select
          name="sort_by"
          id="sort_by"
          class="form-control border-0 bg-transparent  sortby"
          data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3"
          @change="sortBy($event)"
        >
          <option value="">Recommended</option>
          <option value="price,asc ">Price(low to high)</option>
          <option value="price,desc">Price(high to low)</option>
        </select>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters({
      properties: "properties",
      meta: "meta",
    }),
  },
  methods: {
    ...mapActions({
      getProperties: "getProperties",
    }),
    sortBy(e) {
      const url = new URL(window.location);
      url.searchParams.set("sort_by", e.target.value);
      window.history.pushState({}, "", url);
      this.getProperties(window.location);
    },
  },
};
</script>
