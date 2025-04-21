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
            <p class="font-weight-500 text-heading mb-0">
              {{ booking_details.from }}
            </p>
          </li>
          <li class="d-flex justify-content-between mb-3 lh-22">
            <p class="text-gray-light mb-0 bold-2">Check out</p>
            <p class="font-weight-500 text-heading mb-0">
              {{ booking_details.to }}
            </p>
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
        v-for="booking in bookings"
        :key="booking.id"
        class="p-3 bg-transparent d-flex justify-content-between p-0 align-items-center"
      >
        <template v-if="booking.sale_price">
          <div>
            <div>
              {{ booking.apartment.name || property.name }}
            </div>
            <span class="bold-2">
              <del
                >{{ booking.currency
                }}{{ booking.regular_price | priceFormat }}</del
              >
              {{ booking.currency }}{{ booking.sale_price | priceFormat }} X
              {{ booking_details.days_not_in_peak_period + " night(s)" }}
            </span>
          </div>
          <span class="text-size-2"> per night</span>
          <div class="bold-2">
            {{ property.currency
            }}{{
              (booking.regular_price *
                booking_details.days_not_in_peak_period_total)
                | priceFormat
            }}
          </div>
        </template>
        <template v-else>
          <div>
            <div>
              {{ booking.apartment.name || property.name }}
            </div>
            <div class="bold-2">
              {{ property.currency }}{{ booking.regular_price | priceFormat }} X
              {{ booking_details.days_not_in_peak_period + " night(s)" }}
              <div class="text-size-2">per night</div>
              <span
                v-if="booking_details.is_peak_period_present"
                class="badge bg-primary"
                >Regular</span
              >
            </div>
          </div>
          <div class="bold-2">
            {{ property.currency
            }}{{
              (booking.regular_price * booking_details.days_not_in_peak_period)
                | priceFormat
            }}
          </div>
        </template>
      </div>

      <div
        v-if="booking_details.is_peak_period_present"
        class="p-3 bg-transparent d-flex justify-content-between p-0 align-items-center"
      >
        <div>
          <div class="bold-2">
            {{ property.currency
            }}{{ booking_details.peak_price | priceFormat }} X
            {{ booking_details.days_in_peak_period + " night(s)" }}
            <div class="text-size-2">per night</div>
            <span class="badge bg-primary">Peak Period</span>
          </div>
        </div>
        <div class="bold-2">
          {{ property.currency
          }}{{
            (booking_details.peak_price * booking_details.days_in_peak_period)
              | priceFormat
          }}
        </div>
      </div>

      <div
        v-if="booking_details.is_peak_period_present"
        class="alert alert-success p-3 ml-3"
        role="alert"
      >
        <strong>Note:</strong> Due to the peak period, prices from
        {{ booking_details.peak_period.from_date }} to
        {{ booking_details.peak_period.to_date }} are at
        <span class="fw-bold">
          {{ property.currency
          }}{{ booking_details.peak_price | priceFormat }}</span
        >
        per night.
      </div>
      <div
        class="card-footer p-3 bg-transparent d-flex justify-content-between p-0 align-items-center"
      >
        <p class="text-heading mb-0 bold-2">Sub Total</p>
        <span class="text-heading total-price bold-3"
          >{{ property.currency }}{{ parseInt(sub_total) | priceFormat }}</span
        >
      </div>

      <div
        class="card-footer p-3 bg-transparent d-flex justify-content-between p-0 align-items-center"
      >
        <p class="text-heading bold-3 mb-0">Total Price:</p>
        <span
          :data-total="
            bookingTotal + bookingPropertyServicesTotal + bookingServicesTotal
          "
          class="bold-3 text-heading total-price price"
        >
          <template
            v-if="voucher && typeof voucher !== 'undefined' && voucher.length"
          >
            <span class="text-danger fs-3">
              <del>
                {{ property.currency
                }}{{
                  (bookingTotal +
                    bookingPropertyServicesTotal +
                    bookingServicesTotal)
                    | priceFormat
                }}
              </del></span
            >
            {{ property.currency }}{{ voucher[0].sub_total | priceFormat }}

            <p class="fs-5">{{ voucher[0].percent }}</p>
          </template>
          <template v-else>
            {{ property.currency
            }}{{
              (bookingTotal +
                bookingPropertyServicesTotal +
                bookingServicesTotal)
                | priceFormat
            }}
          </template>
        </span>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  props: [
    "booking_details",
    "voucher",
    "sub_total",
    "bookings",
    "amount",
    "property",
  ],
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
