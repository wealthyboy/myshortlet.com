<template>
  <div class=" bg-white">
    <div class=" position-relative loaded-apartments">
      <div class="row no-gutters">
        <div class="col-md-3 position-relative">
          <div>
            <a target="_blank" :href="property.link">
              <img :src="property.image_m" class="img  img-fluid" />
            </a>
          </div>
        </div>
        <div class="col-md-9 position-relative col-12 pl-3">
          <div class="d-flex  justify-content-between">
            <div>
              <a class="bold-2" :href="property.link">{{ property.name }}</a>
              <div class="d">
                <small><a :href="property.link" class="p-0">{{ property.city }}</a>, <a href="">{{ property.state
                }}</a></small>
              </div>
              <div class="mb-5">
                <div v-if="property.facilities.length" class="facilities">
                  <span :key="facility.id" v-for="facility in property.facilities">{{ facility.name }}.
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
                <div v-if="property.free_services.length" class="d-inline-flex">
                  <div v-for="free_service in property.free_services" :key="free_service.id"
                    class="refundable mr-2 text-gold">
                    {{ free_service.name }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end">
            <div class="reviews-section"></div>
            <div class="text-right mr-2">
              <div class="d-inline-flex"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    property: Object,
  },
};
</script>
