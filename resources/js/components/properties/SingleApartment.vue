<template>
  <div :class="{ 'header-filter': propertyLoading }" class="name  rounded mt-1 bg-white">
    <div class="card-body">
      <form id="single-form" :action="'/book/' + property.slug" method="GET">
        <input type="hidden" :name="'apartment_quantity[' + room.uuid + ']'" id="qty" />
        <div class="d-flex pb-3 border-bottom mb-3 justify-content-between">
          <template v-if="room.discounted_price">
            <div class="d-none d-lg-block ">
              <div>
                <del>{{ room.currency
                }}{{ room.converted_price | priceFormat }}</del>
              </div>
              <span>{{ room.currency
              }}{{ room.discounted_price | priceFormat }}</span><span> per night</span>
            </div>
            <div>{{ room.percentage_off }}% off</div>
          </template>
          <template v-else>
            <div class="bold price">
              {{ room.currency }}{{ room.converted_price | priceFormat }}
            </div>
          </template>
        </div>
        <div v-if="room.property.is_refundable" class="mb-3  text-size-1 text-danger">
          <i class="fas fa-info-circle text-danger mr-2"></i>Non - refundable
        </div>

        <div class="text-gold text-size-2">
          <i class="fas fa-info-circle mr-2 mb-3  text-gold "></i>Instant
          Confirmation
        </div>

        <div class="form-row mt-2">
          <div v-if="!propertyLoading && room.reservation_id" class="text-danger mb-2">
            This property is not available for your selected date. Try changing
            your dates
          </div>

          <div class="form-group ml-1 form-border cursor-pointer search col-md-12 bmd-form-group">
            <label class="pl-2 " for="flatpickr-input-f">Check-in - Check-out</label>
            <date :isDateNeedsToToOpen="isDateNeedsToToOpen" @dateSelected="dateSelected" />
          </div>
        </div>
        <div>
          <ul class="list-unstyled mb-0 p-2">
            <li class="d-flex justify-content-between mb-2 lh-22">
              <p v-if="stays" class="text-gray-light mb-0">
                {{ stays[0] || 0 }} {{ stays[1] || "night" }}
              </p>
              <p v-if="!stays">Choose dates</p>
              <p class=" bold text-heading mb-0">
                {{ room.currency
                }}{{ parseInt(stays[0] || 0) * room.display_price }}
              </p>
            </li>
            <li class="d-flex justify-content-between mb-2 lh-22">
              <p class="text-gray-light mb-0">Apartment(s)</p>
              <p class="bold text-heading mb-0">1</p>
            </li>
          </ul>
        </div>
        <div class="card-footer pt-4 bg-transparent d-flex justify-content-between p-0 align-items-center">
          <p class="text-heading mb-0">Total Price:</p>
          <span class="fs-32 bold price  text-heading total-price">{{ room.currency
          }}{{ room.display_price * parseInt(stays[0] || 0) }}</span>
        </div>
        <button type="submit" @click.prevent="checkAvailabity()" class=" btn btn-primary btn-round  mt-3  btn-block">
          <div v-if="propertyLoading" class="auth-spinner ">
            <div class="lds-ellipsis">
              <div style="background: rgb(255, 255, 255);"></div>
              <div style="background: rgb(255, 255, 255);"></div>
              <div style="background: rgb(255, 255, 255);"></div>
              <div style="background: rgb(255, 255, 255);"></div>
            </div>
          </div>
          <span v-if="!propertyLoading" class="lt bold text-white">{{
            text
          }}</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import Pickr from "vue-flatpickr-component";
import axios from "axios";
import Date from "./Date.vue";

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
      isDateAvailable: false,
      loading: false,
      propertyLoading: false,
      isDateNeedsToToOpen: false,
      form: {
        room_quantity: [],
        selectedRooms: [],
        children: null,
        adults: null,
        rooms: null,
        property_id: this.property.id,
        check_in_checkout: null,
      },
    };
  },
  created() {
    this.stays = this.nights;
    this.room = this.apartment;
    this.text = this.stays[1] ? "Reserving..." : "Check availability";
  },
  components: {
    Pickr,
    Date,
  },
  methods: {
    dateSelected(value) {
      this.form.check_in_checkout = value;
    },
    checkAvailabity() {
      if (
        !this.form.check_in_checkout ||
        this.form.check_in_checkout.split(" ").length < 2
      ) {
        this.isDateNeedsToToOpen = true;
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
        .catch((error) => { });
    },
  },
};
</script>
