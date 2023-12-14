<template>
  <div class="  bg-transparent d-flex justify-content-between p-0 align-items-center">
    <div class="checkbox">
      <label id="box50" class="checkbox-label">
        <input for="box50" name="prices[]" :value="extra_service.id" class="property-filter-attribute" type="checkbox"
          @change="addServices()" :data-price="extra_service.pivot.price" />
        <span class="checkbox-custom rectangular"></span>
        <span class="checkbox-label-text mt-1">{{
          extra_service.name
        }}</span>
      </label>
    </div>
    <span class="fs-32 mt-4 bold-2 text-heading total-price">{{ property.currency }}{{ extra_service.pivot.price |
      priceFormat }}
    </span>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  props: {
    extra_service: Object,
    property: Object,
  },
  computed: {
    ...mapGetters({
      bookingTotal: "bookingTotal",
      bookingSubTotal: "bookingSubTotal",
      bookingPropertyServicesTotal: "bookingPropertyServicesTotal",
      bookingServicesTotal: "bookingServicesTotal",
    }),
  },
  methods: {
    addServices() {
      let services = {},
        total = [],
        extras = [];
      var inputs = document.querySelectorAll(
        "input.property-filter-attribute:checked"
      );
      let checkChecked = [];
      let checked_ids = [];

      for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].checked) {
          checkChecked.push(inputs[i].dataset.price);
          checked_ids.push(inputs[i].value);
        }
      }

      let amnt = this.sum(checkChecked);

      this.$store.commit("setBookingPropertyServicesTotal", amnt);

      this.$emit("addExtraPropertyService", { extras: checked_ids });
    },
    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },
  },
};
</script>
