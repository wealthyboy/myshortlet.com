<template>
  <div>
    <div class="bg-white">
      <div class="card-title custom-border-bottom p-3 text-size-1-big bold-3">
        Your Booking Details
      </div>
      <div>
        <ul class="list-unstyled mb-2 p-3">
          <li class="d-flex justify-content-between mb-3 lh-22">
            <p class="text-gray-light mb-0 bold-2">Check in</p>
            <p class="font-weight-500 text-heading mb-0">{{ booking_details.from }}</p>
          </li>
          <li class="d-flex justify-content-between mb-3 lh-22">
            <p class="text-gray-light mb-0 bold-2">Check out</p>
            <p class="font-weight-500 text-heading mb-0">{{ booking_details.to }}</p>
          </li>
          <li class="d-flex justify-content-between lh-22">
            <p class="text-gray-light mb-0 bold-2">Total length of stay</p>
            <p class="font-weight-500 text-heading mb-0">
              {{ booking_details.days }} {{ booking_details.nights[1] }}
            </p>
          </li>
        </ul>
      </div>
    </div>

    <div class="bg-white mt-2">
      <div class="card-title bold-3 custom-border-bottom p-3 text-size-1-big">
        Price Details
      </div>

      <div
        v-if="booking_details.days_not_in_peak_period > 0"
        class="p-3 bg-transparent d-flex justify-content-between align-items-center"
      >
        <div>
          <div v-if="bookings.length && bookings[0].apartment">
            {{ bookings[0].apartment.name || property.name }}
          </div>
          <div class="bold-2">
            {{ currencySymbol }}{{ booking_details.regular_price | priceFormat }} X
            {{ booking_details.days_not_in_peak_period }} night(s)
            <div class="text-size-2">per night</div>
            <span v-if="booking_details.is_peak_period_present" class="badge bg-primary">Regular</span>
          </div>
        </div>
        <div class="bold-2">
          {{ currencySymbol }}{{ booking_details.days_not_in_peak_period_total | priceFormat }}
        </div>
      </div>

      <div
        v-if="booking_details.is_peak_period_present"
        class="p-3 bg-transparent d-flex justify-content-between align-items-center"
      >
        <div>
          <div class="bold-2">
            {{ currencySymbol }}{{ booking_details.peak_price | priceFormat }} X
            {{ booking_details.days_in_peak_period }} night(s)
            <div class="text-size-2">per night</div>
            <span class="badge bg-primary">
              Peak Period<span v-if="booking_details.peak_percentage"> +{{ booking_details.peak_percentage }}%</span>
            </span>
          </div>
        </div>
        <div class="bold-2">
          {{ currencySymbol }}{{ booking_details.peak_period_total | priceFormat }}
        </div>
      </div>

      <div
        v-if="booking_details.is_peak_period_present && booking_details.peak_periods && booking_details.peak_periods.length"
        class="alert alert-success p-3 ml-3 mr-3"
        role="alert"
      >
        <strong>Peak pricing applied to your selected stay:</strong>
        <div v-for="period in booking_details.peak_periods" :key="period.id || period.start_date">
          {{ period.from_date }} to {{ period.to_date }}: +{{ period.percentage }}%
        </div>
      </div>

      <div class="card-footer p-3 bg-transparent d-flex justify-content-between align-items-center">
        <p class="text-heading mb-0 bold-2">Accommodation Sub Total</p>
        <span class="text-heading total-price bold-3">
          {{ currencySymbol }}{{ parseInt(sub_total || 0) | priceFormat }}
        </span>
      </div>

      <div class="card-footer p-3 bg-transparent d-flex justify-content-between align-items-center">
        <p class="text-heading bold-3 mb-0">Total Price:</p>
        <span :data-total="grandTotal" class="bold-3 text-heading total-price price">
          <template v-if="voucher && voucher.length">
            <span class="text-danger fs-3">
              <del>{{ currencySymbol }}{{ fullPriceBeforeVoucher | priceFormat }}</del>
            </span>
            {{ currencySymbol }}{{ grandTotal | priceFormat }}
            <p class="fs-5">{{ voucher[0].percent }}</p>
          </template>
          <template v-else>
            {{ currencySymbol }}{{ grandTotal | priceFormat }}
          </template>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: [
    "booking_details",
    "voucher",
    "sub_total",
    "bookings",
    "amount",
    "property",
  ],
  computed: {
    ...mapGetters({
      bookingTotal: "bookingTotal",
      bookingPropertyServicesTotal: "bookingPropertyServicesTotal",
      bookingServicesTotal: "bookingServicesTotal",
    }),
    currencySymbol() {
      return this.booking_details.currency_symbol || this.property.currency;
    },
    fullPriceBeforeVoucher() {
      return Number(this.bookingTotal || 0) +
        Number(this.bookingPropertyServicesTotal || 0) +
        Number(this.bookingServicesTotal || 0);
    },
    grandTotal() {
      const accommodation = this.voucher && this.voucher.length
        ? Number(this.voucher[0].sub_total || 0)
        : Number(this.bookingTotal || 0);

      return accommodation +
        Number(this.bookingPropertyServicesTotal || 0) +
        Number(this.bookingServicesTotal || 0);
    },
  },
};
</script>
