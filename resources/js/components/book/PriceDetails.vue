<template>
  <div>
    <div class="bg-white ">
      <div class="card-title border-bottom p-3 text-size-1-big">
        Your Booking Details
      </div>
      <div>
        <ul class="list-unstyled mb-2 p-3">
          <li class="d-flex justify-content-between  mb-3 lh-22">
            <p class="text-gray-light mb-0">Check in</p>
            <p class="font-weight-500 text-heading mb-0">
              {{ booking_details.from }}
            </p>
          </li>
          <li class="d-flex justify-content-between mb-3 lh-22">
            <p class="text-gray-light mb-0">Check out</p>
            <p class="font-weight-500 text-heading mb-0">
              {{ booking_details.to }}
            </p>
          </li>
          <li class="d-flex justify-content-between lh-22">
            <p class="text-gray-light mb-0">Total length of stay</p>
            <p class="font-weight-500 text-heading mb-0">
              {{ booking_details.days }} {{ booking_details.nights[1] }}
            </p>
          </li>
        </ul>
      </div>
    </div>
    <div class="bg-white mt-2">
      <div class="card-title border-bottom p-3 text-size-1-big">
        Price Details
      </div>

      <div
        v-for="booking in bookings"
        :key="booking.id"
        class=" p-3  bg-transparent d-flex justify-content-between p-0 align-items-center"
      >
        <template v-if="booking.sale_price">
          <div>
            <div>
              {{ booking.quantity }} X
              {{ booking.apartment.name || property.name }}
            </div>
            <span class="bold">
              <del>{{ booking.currency }}{{ booking.price | priceFormat }}</del>
              {{ booking.currency }}{{ booking.sale_price | priceFormat }}
            </span>
          </div>
          <span class="text-size-2"> per night</span>
          <div class="bold">
            {{ property.currency }}{{ booking.total | priceFormat }}
          </div>
        </template>
        <template v-else>
          <div>
            <div>
              {{ booking.quantity }} X
              {{ booking.apartment.name || property.name }}
            </div>
            <div class="bold">
              {{ property.currency }}{{ booking.price | priceFormat }}
              <div class="text-size-2">per night</div>
            </div>
          </div>
          <div class="bold">
            {{ property.currency }}{{ booking.total | priceFormat }}
          </div>
        </template>
      </div>
      <div
        class="card-footer p-3  bg-transparent d-flex justify-content-between p-0 align-items-center"
      >
        <p class="text-heading mb-0">
          Sub Total
        </p>
        <span class=" text-heading total-price bold"
          >{{ property.currency }}{{ parseInt(sub_total) | priceFormat }}</span
        >
      </div>

      <div
        class="card-footer p-3  bg-transparent d-flex justify-content-between p-0 align-items-center"
      >
        <p class="text-heading bold mb-0">
          Total Price:
        </p>
        <span
          :data-total="
            bookingTotal + bookingPropertyServicesTotal + bookingServicesTotal
          "
          class=" bold text-heading total-price price"
          >{{ property.currency
          }}{{
            (bookingTotal +
              bookingPropertyServicesTotal +
              bookingServicesTotal)
              | priceFormat
          }}</span
        >
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  props: ["booking_details", "sub_total", "bookings", "amount", "property"],
  data() {
    return {};
  },
  computed: {
    ...mapGetters({
      bookingTotal: "bookingTotal",
      bookingPropertyServicesTotal: "bookingPropertyServicesTotal",
      bookingServicesTotal: "bookingServicesTotal",
    }),
  },
};
</script>
