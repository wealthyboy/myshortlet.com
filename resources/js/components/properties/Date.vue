<template>
  <div class="input-group input-group-lg">
    <div class="input-group-prepend">
      <span
        class="input-group-text  border-0 text-muted fs-18"
        id="inputGroup-sizing-lg"
      >
        <i class="fal fa-calendar-week"></i>
      </span>
    </div>
    <pickr
      v-model="date"
      :config="config"
      class="form-control cursor-pointer ml-2"
      placeholder="Check in - Check out"
      name="date"
      @on-change="getApartmentAvailability"
    />
  </div>
</template>
<script>
import Pickr from "vue-flatpickr-component";

export default {
  data() {
    return {
      guests: 0,

      check_in_checkout: this.$root.request.check_in_checkout,
      config: {
        wrap: true, // set wrap to true only when using 'input-group'
        altFormat: "M j, Y",
        altInput: true,
        mode: "range",
        minDate: "today",
        dateFormat: "Y-m-d",
        showMonths: 2,
      },
    };
  },
  components: {
    Pickr,
  },
};
</script>
