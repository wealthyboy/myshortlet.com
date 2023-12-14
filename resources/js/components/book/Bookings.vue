<template>
  <div class="bg-white mt-2">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h4 class="card-title p-3 mb-0 bold-2">
          {{ booking.apartment.name || property.name }}
        </h4>
      </div>

      <div v-if="bookings.length > 1" class="mr-2 ">
        <a @click.prevent="
          removeFromBooking($event, booking.id, booking.apartment.id)
          " href="">
          <i class="fas fa-trash"></i> Remove</a>
      </div>
    </div>

    <div class="card-body pt-0">
      <div class="text-gold">
        <i class="fas fa-info-circle mr-2 text-gold text-size-2"></i>Instant
        Confirmation
      </div>
      <div class="entire-apartment">
        <div class="mb-3">Entire apartment</div>
        <div class="d-flex justify-content-between flex-wrap">
          <div class="position-relative">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#bedrooms-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ booking.apartment.no_of_rooms }} Bedrooms
              {{ booking.apartment.id }}</span>
          </div>
          <div class="position-relative">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#bathroom-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ booking.apartment.toilets }} bathrooms</span>
          </div>
          <div class="position-relative">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#sleeps-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ booking.apartment.guests }} Guests</span>
          </div>
        </div>
      </div>

      <div class="position-relative">
        <span class="position-absolute svg-icon-section"></span>
        <span class="svg-icon-text">Air condition</span>
      </div>

      <div v-if="booking.apartment.free_services.length" class="d-inline-flex flex-wrap">
        <div v-for="free_service in booking.free_services" :key="free_service.id" class="position-relative">
          <span class="position-absolute svg-icon-section"></span>
          <span class="svg-icon-text">{{ free_service.name }} included</span>
        </div>
      </div>

      <template v-if="booking.apartment.bedrooms.length">
        <div v-for="bed in booking.apartment.bedrooms" :key="bed.id" class="position-relative">
          <span class="position-absolute svg-icon-section"></span>
          <span class="svg-icon-text">{{ bed.parent.name }}</span>
          <span class="svg-icon-text">
            {{ bed.pivot.bed_count }} {{ bed.name }}</span>
        </div>
      </template>

      <template v-if="booking.apartment.extra_services.length">
        <div class="card-title ">Extras</div>
        <p>We offer</p>
        <div style="height: 150px; overflow: scroll;">
          <div :key="x" v-for="x in parseInt(booking_details.days)">
            <div v-for="extra_service in booking.apartment.extra_services" :key="extra_service.id"
              class="card-footer    bg-transparent d-flex justify-content-between p-0 align-items-center">
              <div class="checkbox mt-3">
                <label id="box50" class="checkbox-label">
                  <input for="box50" :name="'extra_services_' +
                    booking.apartment.id +
                    '_' +
                    extra_service.id
                    " :class="'extra_services_' + booking.apartment.id" :value="extra_service.id"
                    class="filter-attribute" type="radio" @click="addServices($event)" :data-quantity="parseInt(x)"
                    :data-price="extra_service.pivot.price * parseInt(x)" :data-apartment="booking.apartment.id" />
                  <span class="checkbox-custom rectangular"></span>
                  <span class="checkbox-label-text mt-1">{{ extra_service.name }}
                  </span>
                </label>
                <p>{{ x }} {{ x > 1 ? "nights" : "night" }}</p>
                <p>
                  {{ extra_service.description }}
                </p>
              </div>
              <span class="fs-32 mt-4 font-weight-bold-2 text-heading total-price">
                {{ property.currency
                }}{{
  (parseInt(x) * extra_service.pivot.price) | priceFormat
}}</span>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  props: {
    booking: Object,
    property: Object,
    booking_details: Object,
    bookings: Array,
  },
  data() {
    return { amount: 0, checkboxesChecked: [], extras: [], isChecked: false };
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
    ...mapActions({
      deleteBooking: "deleteBooking",
    }),
    addServices(evt) {
      this.isChecked = !this.isChecked;

      if (!evt.target.classList.contains("checked")) {
        this.isChecked = true;
      }

      if (this.isChecked) {
        evt.target.checked = true;
        evt.target.classList.add("checked");
      } else {
        evt.target.checked = false;
        evt.target.classList.remove("checked");
      }

      let services = {},
        checkboxesChecked = [],
        extras = [];
      var inputs = document.querySelectorAll("input.filter-attribute:checked");

      for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].checked) {
          checkboxesChecked.push(inputs[i].dataset.price);
          services = {
            [inputs[i].dataset.apartment]: {
              [inputs[i].value]: inputs[i].dataset.quantity,
            },
          };
          extras.push(services);
        }
      }

      let amt = this.sum(checkboxesChecked);
      this.$store.commit("setBookingServicesTotal", amt);
      this.$emit("addExtraService", { extras: extras });
    },
    removeFromBooking(evt, booking_id, ap_id) {
      let attributes = document.querySelectorAll(".extra_services_" + ap_id);
      let c = [],
        services = {},
        checkboxesChecked = [],
        extras = [];

      for (var i = 0; i < attributes.length; i++) {
        if (attributes[i].checked) {
          c.push(attributes[i].dataset.price);
        }
      }

      var inputs = document.querySelectorAll("input.filter-attribute:checked");
      for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].checked) {
          checkboxesChecked.push(inputs[i].dataset.price);
          services = {
            [inputs[i].dataset.apartment]: {
              [inputs[i].value]: inputs[i].dataset.quantity,
            },
          };
          extras.push(services);
        }
      }

      //let price = c.shift();

      extras.forEach((e, i) => {
        for (const key in e) {
          if (e.hasOwnProperty.call(e, key)) {
            delete extras[i][ap_id];
          }
        }
      });

      // console.log(price);
      c.forEach((e, i) => {
        console.log(e);
        const index = checkboxesChecked.indexOf(e);
        if (index != -1) {
          checkboxesChecked.splice(index, 1);
        }
      });

      let amount = this.sum(checkboxesChecked);
      this.$store.commit("setBookingServicesTotal", amount);

      this.deleteBooking({
        context: this,
        booking_id: booking_id,
        property_id: this.property.id,
        amount: amount,
      }).then((res) => {
        this.$emit("addExtraService", { extras: extras });
      });
    },
    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },
  },
};
</script>
