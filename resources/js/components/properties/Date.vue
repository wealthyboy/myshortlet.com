<template>
  <div class="input-group input-group-lg">
    <div class="input-group-prepend">
      <span class="input-group-text" id="inputGroup-sizing-lg">
        <svg style="" id="date-outline">
          <use xlink:href="#date-icon"></use>
        </svg>
      </span>
    </div>
    <pickr v-model="check_in_checkout" :config="config" class="form-control date-range cursor-pointer  location-search"
      placeholder="Check in - Check out" name="check_in_checkout" ref="datePicker" @on-change="dateSelected" style="" />
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
      check_in_checkout: null,
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
  mounted() {
    this.check_in_checkout = this.checkForDate()
  },
  components: {
    Pickr,
  },
  watch: {
    isDateNeedsToToOpen: {
      handler(val, oldVal) {
        if (val) {
          this.$refs.datePicker.fp.open();
        }
      },
    },
  },
  methods: {
    dateSelected() {
      this.$emit("dateSelected", this.check_in_checkout);
    },

    checkForDate(e) {
      const retrievedJsonString = localStorage.getItem('searchParams');
      // Check if the retrieved JSON string is not null
      if (retrievedJsonString !== null) {
        // Convert the JSON string back to an object
        const retrievedObject = JSON.parse(retrievedJsonString);

        console.log(retrievedObject)
        return retrievedObject.check_in_checkout
      } else {
        return null
      }
    }
  },
};
</script>
