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
      @on-open="updateMinDate"
      @on-change="handleDateChange(placeholder)"
      :id="placeholder"
      v-model="check_in_checkout"
      :config="config"
      class="form-control date-range cursor-pointer location-search"
      :placeholder="placeholder"
      name="check_in_checkout"
      ref="datePicker"
    />
  </div>
</template>
<script>
import Pickr from "vue-flatpickr-component";

export default {
  props: {
    isDateNeedsToToOpen: Boolean,
    placeholder: String,
    check_in_date: Number,
    checkout_date: String,
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
    const urlParams = new URLSearchParams(window.location.search);

    const checkin = urlParams.get("checkin");
    const checkout = urlParams.get("checkout");

    // Simple date validation
    const isValidDate = (dateStr) => !isNaN(Date.parse(dateStr));

    if (this.check_in_date === 1) {
      if (
        this.checkForDate() &&
        typeof this.checkForDate().checkin !== "undefined"
      ) {
        this.check_in_checkout = this.checkForDate().checkin;
      } else if (checkin && isValidDate(checkin)) {
        this.check_in_checkout = checkin;
      } else {
        this.check_in_checkout = null;
      }
    } else {
      if (
        this.checkForDate() &&
        typeof this.checkForDate().checkout !== "undefined"
      ) {
        this.check_in_checkout = this.checkForDate().checkout;
      } else if (checkout && isValidDate(checkout)) {
        this.check_in_checkout = checkout;
      } else {
        this.check_in_checkout = null;
      }
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
    getMinDate() {
    const now = new Date();
    const hour = now.getHours();

    // Between 12:00 AM and 8:59 AM — allow yesterday
    if (hour < 9) {
      const yesterday = new Date();
      yesterday.setDate(yesterday.getDate() - 1);
      return yesterday;
    }

    // From 9:00 AM onwards — today
    return "today";
  },

  updateMinDate() {
    if (this.$refs.datePicker && this.$refs.datePicker.flatpickr) {
      const newMinDate = this.getMinDate();
      this.$refs.datePicker.flatpickr.set("minDate", newMinDate);
    }
  },
    handleDateChange(pickerId) {
      this.$emit("dateSelected", this.check_in_checkout);
    },
    dateSelected() {
      this.$emit("dateSelected", this.check_in_checkout);
    },
    isCheckinEqualsToCheckout(checkinDate, checkoutDate) {
      checkinDate = new Date(checkinDate);
      checkoutDate = new Date(checkoutDate);
      return checkinDate === checkoutDate;
    },

    checkForDate(e) {
      const retrievedJsonString = localStorage.getItem("searchParams");
      // Check if the retrieved JSON string is not null
      if (retrievedJsonString !== null) {
        // Convert the JSON string back to an object
        const retrievedObject = JSON.parse(retrievedJsonString);

        if (new Date().getTime() < retrievedObject.expiry) {
          return retrievedObject;
        } else {
          // Remove expired data from storage
          localStorage.removeItem("searchParams");
          return null;
        }
      } else {
        return null;
      }
    },
  },
};
</script>
