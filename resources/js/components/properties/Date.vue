<template>
  <div class="input-group input-group-lg">
    <div class="input-group-prepend">
      <span class="input-group-text" id="inputGroup-sizing-lg">
        <svg style="" id="date-outline">
          <use xlink:href="#date-icon"></use>
        </svg>
      </span>
    </div>
    <pickr @on-change="handleDateChange(placeholder)" :id="placeholder" v-model="check_in_checkout" :config="config"
      class="form-control date-range cursor-pointer  location-search" :placeholder="placeholder" name="check_in_checkout"
      ref="datePicker" style="" />
  </div>
</template>
<script>
import Pickr from "vue-flatpickr-component";

export default {
  props: {
    isDateNeedsToToOpen: Boolean,
    placeholder: String,
    check_in_date: Number,
    checkout_date: String

  },
  data() {
    return {
      guests: 0,
      check_in_checkout: null,

      config: {
        wrap: true, // set wrap to true only when using 'input-group'
        altFormat: "M j, Y",
        altInput: true,
        minDate: "today",
        dateFormat: "Y-m-d",
        showMonths: 1,
        disableMobile: "true",
      },
    };
  },
  mounted() {
    console.log(this.checkForDate())
    if (this.check_in_date === 1) {
      this.check_in_checkout = this.checkForDate() && typeof this.checkForDate().checkin !== 'undefined' ? this.checkForDate().checkin : null
    } else {
      this.check_in_checkout = this.checkForDate() && typeof this.checkForDate().checkout !== 'undefined' ? this.checkForDate().checkout : null
    }

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
    handleDateChange(pickerId) {
      this.$emit("dateSelected", this.check_in_checkout);
    },
    dateSelected() {
      // const flatpickrDaySpans = document.querySelectorAll('span.flatpickr-day');

      // // Loop through each span element
      // flatpickrDaySpans.forEach(span => {
      //   // Remove the 'today' class from each span
      //   span.classList.remove('today');
      // });
      this.$emit("dateSelected", this.check_in_checkout);
    },
    isCheckinEqualsToCheckout(checkinDate, checkoutDate) {
      checkinDate = new Date(checkinDate);
      checkoutDate = new Date(checkoutDate);
      return checkinDate === checkoutDate;
    },

    checkForDate(e) {
      const retrievedJsonString = localStorage.getItem('searchParams');
      // Check if the retrieved JSON string is not null
      if (retrievedJsonString !== null) {

        // Convert the JSON string back to an object
        const retrievedObject = JSON.parse(retrievedJsonString);


        if (new Date().getTime() < retrievedObject.expiry) {
          return retrievedObject;
        } else {
          // Remove expired data from storage
          localStorage.removeItem('searchParams');
          return null
        }

      } else {
        return null
      }
    }
  },
};
</script>
