<template>
  <div>
    <div v-if="!propertyLoading && properties.length">
      <div
        v-for="property in properties"
        :key="property.id"
        class="bg-white mb-2 rounded position-relative loaded-apartments"
      >
        <div class="row no-gutters">
          <div class="col-md-3 position-relative">
            <div>
              <a target="_blank" :href="property.link">
                <img :src="property.image_m" class="img  img-fluid" />
              </a>
              <div class="fav-icon position-absolute">
                <saved :property="property" />
              </div>
            </div>
          </div>
          <div class="col-md-9 position-relative col-12 pl-3">
            <div class="d-flex  justify-content-between">
              <div>
                <a target="_blank" :href="property.link">{{ property.name }}</a>
                <div class="d">
                  <small
                    ><a :href="property.link" class="p-0">{{ property.city }}</a
                    >, <a href="">{{ property.state }}</a></small
                  >
                </div>
                <div class="mb-5">
                  <div v-if="property.facilities.length" class="facilities">
                    <span
                      :key="facility.id"
                      v-for="facility in property.facilities"
                      >{{ facility.name }}.
                    </span>
                  </div>

                  <div v-if="property.type == 'single'" class="guests-section">
                    <span>{{ property.guests }} guests</span>
                    <span aria-hidden="true"> · </span>
                    <span>{{ property.rooms }} bedroom</span>
                    <span aria-hidden="true"> · </span>
                    <span>{{ property.baths }} baths</span>
                  </div>

                  <div v-if="property.is_refundable">Fully Refundable</div>
                  <div
                    v-if="property.free_services.length"
                    class="d-inline-flex"
                  >
                    <div
                      v-for="free_service in property.free_services"
                      :key="free_service.id"
                      class="refundable"
                    >
                      {{ free_service.name }} included
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end"
            >
              <div class="reviews-section"></div>
              <div class="text-right mr-2">
                <div class="d-inline-flex">
                  <template v-if="property.default_discounted_price">
                    <div class="sale-price mr-3">
                      {{ property.currency }}{{ property.converted_price }}
                    </div>
                    <div class="price">
                      {{ property.currency
                      }}{{ property.default_discounted_price }}
                    </div>
                  </template>
                  <template v-else>
                    <div class="price">
                      {{ property.currency }}{{ property.converted_price }}
                    </div>
                  </template>
                </div>
                <div>per night</div>
                <div v-if="property.is_refundable">Fully Refundable</div>
                <a
                  target="_blank"
                  :href="property.link"
                  class="btn btn-primary btn-round d-none d-lg-block d-xl-block"
                >
                  Check Availability
                  <i class="material-icons">arrow_forward_ios</i></a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      id="pagination"
      v-if="!propertyLoading && properties.length && next_page_url"
      class="d-flex justify-content-center"
    >
      <a
        :href="next_page_url"
        id="load_more"
        @click.prevent="loadMore($event)"
        class="btn btn-primary  mt-4 mb-2"
      >
        <span class="spinner-grow spinner-grow-md d-none"></span>
        Load More ...
        {{ properties.total }}
      </a>
    </div>

    <div
      v-if="!propertyLoading && !properties.length"
      class="no-properties-found"
    >
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

export default {
  name: "Index",
  props: {
    user: Object,
    propertys: Array,
    next_page: Array,
  },
  components: {
    Pagination,
    Loaders,
    Saved,
  },
  data() {
    return {
      meta: {},
      has_filters: 0,
      full_width: false,
      loading: false,
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

  created() {
    this.$store.commit("setPropertyLoading", true);
    let time = new Date().getTime();
    setTimeout(() => {
      this.$store.commit("setProperties", this.propertys);
      this.$store.commit("setPropertyLoading", false);
    }, 1000);
    this.$store.commit("setNextPageUrl", this.next_page[0]);
  },
  methods: {
    ...mapActions({
      getProperties: "getProperties",
      saveProperty: "saveProperty",
    }),
    favorite: function(e, property_id) {
      this.saveProperty({
        property_id: property_id,
      }).then((res) => {});
    },
    loadMore(e) {
      let t = new Date().getTime();
      let href = e.target.getAttribute("href");
      this.getProperties(
        href + "&timestamp=${new Date().getTime()}"
      ).then((r) => {});
    },
  },
};
</script>
