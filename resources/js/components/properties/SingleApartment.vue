<template>
  <div
    :class="{ 'header-filter': propertyLoading }"
    class="name  rounded mt-1 bg-white"
  >
    <div class="card-body">
      <form id="single-form" :action="'/book/' + property.slug" method="GET">
        <input
          type="hidden"
          :name="'apartment_quantity[' + room.uuid + ']'"
          id="qty"
        />
        <div class="d-flex pb-3 border-bottom mb-3 justify-content-between">
          <template v-if="room.discounted_price">
            <div>
              <div>
                <del>{{ room.currency }}{{ room.converted_price }}</del>
              </div>
              <span>{{ room.currency }}{{ room.discounted_price }}</span
              ><span> per night</span>
            </div>
            <div>{{ room.percentage_off }}% off</div>
          </template>
          <template v-else>
            <div class="">{{ room.currency }}{{ room.converted_price }}</div>
          </template>
        </div>
        <div v-if="room.property.is_refundable" class="mb-4">
          <i class="fas fa-info-circle mr-2"></i>Non - refundable
        </div>

        <div>
          <i class="fas fa-info-circle mr-2 mb-3"></i>Instant Confirmation
        </div>

        <div class="form-row mt-2">
          <div v-if="!propertyLoading && !room" class="text-danger mb-2">
            This property is not available for your selected date. Try changing
            your dates
          </div>

          <div
            class="form-group form-border search border rounded pl-2 col-md-12 bmd-form-group"
          >
            <label for="flatpickr-input-f" class="pl-2 bmd-label-static"
              >Check-in - Check-out</label
            >

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
                v-model="form.check_in_checkout"
                :config="config"
                class="form-control date-range cursor-pointer ml-2 location-search"
                placeholder="Check in - Check out"
                name="check_in_checkout"
                ref="datePicker"
              />
            </div>
          </div>
        </div>
        <div>
          <ul class="list-unstyled mb-0 p-2">
            <li class="d-flex justify-content-between mb-2 lh-22">
              <p v-if="stays" class="text-gray-light mb-0">
                {{ stays[0] }} {{ stays[1] || "night" }}
              </p>
              <p v-if="!stays">Choose dates</p>
              <p class="font-weight-500 text-heading mb-0">
                {{ room.currency }}{{ stays[0] * room.display_price }}
              </p>
            </li>
            <li class="d-flex justify-content-between mb-2 lh-22">
              <p class="text-gray-light mb-0">Apartment(s)</p>
              <p class="font-weight-500 text-heading mb-0">1</p>
            </li>
          </ul>
        </div>
        <div
          class="card-footer pt-4 bg-transparent d-flex justify-content-between p-0 align-items-center"
        >
          <p class="text-heading mb-0">Total Price:</p>
          <span class="fs-32 font-weight-bold text-heading total-price"
            >{{ room.currency
            }}{{ room.display_price * parseInt(stays[0]) }}</span
          >
        </div>
        <button
          type="submit"
          @click.prevent="checkAvailabity()"
          class=" btn btn-primary btn-round  mt-3  btn-block"
        >
          <div v-if="propertyLoading" class="auth-spinner">
            <div class="lds-ellipsis">
              <div style="background: rgb(255, 255, 255);"></div>
              <div style="background: rgb(255, 255, 255);"></div>
              <div style="background: rgb(255, 255, 255);"></div>
              <div style="background: rgb(255, 255, 255);"></div>
            </div>
          </div>
          <span v-if="!propertyLoading" class="lt">{{ text }}</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import Pickr from "vue-flatpickr-component";
import axios from "axios";

export default {
  props: {
    apartment: Object,
    property: Object,
    nights: Array,
  },
  data() {
    return {
      roomsAvailable: [],
      room: null,
      total: 0,
      aps: 0,
      totalRooms: 0,
      apartment_bed_rooms: 0,
      attrPrice: 0,
      checkedAttr: [],
      guests: 0,
      apQ: [],
      qty: false,
      stays: null,
      propertyQty: [],
      text: "Check Availability",
      loading: false,
      propertyLoading: false,
      form: {
        room_quantity: [],
        selectedRooms: [],
        children: null,
        adults: null,
        rooms: null,
        check_in_checkout: this.$root.request.check_in_checkout,
        property_id: this.property.id,
      },
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
  created() {
    this.stays = this.nights;
    this.room = this.apartment;
    this.text = this.stays[1] ? "Reserve" : "Check availability";
  },
  components: {
    Pickr,
  },
  methods: {
    checkAvailabity() {
      if (!this.form.check_in_checkout) {
        this.$refs.datePicker.fp.open();
        return;
      }

      this.propertyLoading = true;

      if (null != this.stays[1]) {
        var checked = [];
        let filters = {};
        filters = {
          [this.apartment.id]: 1,
        };
        checked.push(filters);
        let form = {
          apartment_quantity: checked,
          property_id: this.property.id,
          check_in_checkout: this.form.check_in_checkout,
        };

        this.propertyLoading = true;
        axios
          .post("/book/store", form)
          .then((response) => {
            document.querySelector("#single-form").submit();
            return;
          })
          .catch((error) => {
            alert("We could not make your reservation.Please try again later");
          });
        return;
      }
      axios
        .post("/check/apartment/availablility", this.form)
        .then((response) => {
          this.roomsAv = response.data.data;
          this.stays = response.data.nights;
          this.propertyLoading = false;
          this.text = "Reserve";
        })
        .catch((error) => {});
    },

    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },

    reserve(e) {
      if (!this.form.check_in_checkout) {
        this.$refs.datePicker.fp.open();
        return false;
      }
      if (this.total < 1) {
        this.qty = true;
      }
    },
  },
};
</script>
