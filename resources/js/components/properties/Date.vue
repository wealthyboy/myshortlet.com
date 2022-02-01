<template>
  <div class="input-group input-group-lg">
    <div class="input-group-prepend">
      <span class="input-group-text" id="inputGroup-sizing-lg">
        <svg style="" id="date-outline">
          <use xlink:href="#date-icon"></use>
        </svg>
      </span>
    </div>
    <pickr
      v-model="check_in_checkout"
      :config="config"
      class="form-control date-range cursor-pointer  location-search"
      placeholder="Check in - Check out"
      name="check_in_checkout"
      ref="datePicker"
      @on-change="dateSelected"
      style=""
    />
  </div>
</template>
<script>
import Pickr from "vue-flatpickr-component";

export default {
  props: {
    isDateNeedsToToOpen: Boolean,
  },
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
  watch: {
    isDateNeedsToToOpen: {
      handler(val, oldVal) {
        if (val) {
          console.log(val);
          this.$refs.datePicker.fp.open();
        }
      },
    },
  },
  methods: {
    dateSelected() {
      console.log(this.check_in_checkout);
      this.$emit("dateSelected", this.check_in_checkout);
    },
  },
};
</script>
