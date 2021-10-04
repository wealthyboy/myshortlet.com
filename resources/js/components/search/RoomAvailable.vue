<template>
  <div class="">
    <form
      action="/book/single-room-apartment-in-ikeja-gra-681247658"
      method="GET"
    >
      <div>
        <h3>Choose your unit</h3>
        <div class="form-row">
          <div
            class="form-group ml-1 form-border cursor-pointer search col-md-4 bmd-form-group"
          >
            <label class="pl-2 ml-4" for="flatpickr-input-f"
              >Check-in - Check-out</label
            >
            <date-range />
          </div>
          <div id="people-number" class="col-md-4 cursor-pointer">
            <guests />
          </div>
          <div class="col-md-3">
            <button
              type="button"
              @click.prevent=""
              class="btn btn-primary btn-block"
            >
              <i class="material-icons">search</i> Search
            </button>
          </div>
        </div>
      </div>
      <div id="" class="name mt-1 rounded bg-white p-2">
        <div class="position-relative">
          <input
            type="hidden"
            name="_token"
            value="xE4PebY96Ovcp5725yeWPkN6r7yRcFdHrG9sDTeq"
          />
          <input type="hidden" name="property_id" value="217" />

          <template v-if="roomsAvailable.length">
            <div
              v-for="room in roomsAvailable"
              :key="room.id"
              class="row border-bottom mb-1 mt-1 pl-1 pb-1"
            >
              <div class="col-md-3 position-relative">
                <div>
                  <img :src="room.images[0].image_m" class="img  img-fluid" />
                </div>
              </div>
              <div class="col-md-7">
                <div></div>
                <div class="card-title">
                  <a href="#">{{ room.name }}</a>
                </div>
                <div>
                  <i class="fas fa-info-circle mr-2"></i>Instant Confirmation
                </div>
                <div class="entire-apartment">
                  <div>Entire apartment</div>
                  <div class="d-flex justify-content-between flex-wrap">
                    <div class="position-relative">
                      <span class="position-absolute svg-icon-section">
                        <svg>
                          <use xlink:href="#bedrooms-icon"></use>
                        </svg>
                      </span>
                      <span class="svg-icon-text"
                        >{{ room.no_of_rooms }} Bedrooms</span
                      >
                    </div>
                    <div class="position-relative">
                      <span class="position-absolute svg-icon-section">
                        <svg>
                          <use xlink:href="#bathroom-icon"></use>
                        </svg>
                      </span>
                      <span class="svg-icon-text"
                        >{{ room.toilets }} bathrooms</span
                      >
                    </div>
                    <div class="position-relative">
                      <span class="position-absolute svg-icon-section">
                        <svg>
                          <use xlink:href="#sleeps-icon"></use>
                        </svg>
                      </span>
                      <span class="svg-icon-text"
                        >{{ room.guests }} Guests</span
                      >
                    </div>
                  </div>
                </div>
                <div class="position-relative">
                  <span class="position-absolute svg-icon-section"></span>
                  <span class="svg-icon-text">Air condition</span>
                </div>

                <div
                  v-if="room.free_services.length"
                  class="d-inline-flex flex-wrap"
                >
                  <div
                    v-for="free_service in room.free_services"
                    :key="free_service.id"
                    class="position-relative"
                  >
                    <span class="position-absolute svg-icon-section"></span>
                    <span class="svg-icon-text">{{ free_service.name }}</span>
                  </div>
                </div>

                <template v-if="room.bedrooms.length">
                  <div
                    v-for="bed in room.bedrooms"
                    :key="bed.id"
                    class="position-relative"
                  >
                    <span class="position-absolute svg-icon-section"></span>
                    <span class="svg-icon-text">{{ bed.parent.name }}</span>
                    <span class="svg-icon-text">
                      {{ bed.pivot.bed_count }} {{ bed.name }}</span
                    >
                  </div>
                </template>

                <div>
                  <div class="price-box">
                    <div class="d-inline-flex ">
                      <template v-if="room.discounted_price">
                        <div class="sale-price mr-3">
                          {{ room.currency }}{{ room.converted_price }}
                        </div>
                        <div class="price">
                          {{ room.currency }}{{ room.discounted_price }}
                        </div>
                      </template>
                      <template v-else>
                        <div class="price">
                          {{ room.currency }}{{ room.converted_price }}
                        </div>
                      </template>
                    </div>
                    <div>per night</div>
                  </div>
                  <div>Fully Refundable</div>
                </div>
              </div>
              <div class="col-md-2 position-relative">
                <div class="form-group">
                  <label for="qty">Qty</label>
                  <select
                    :name="'apartment_quantity[' + room.uuid + ']'"
                    class="form-control room-q"
                    @change="getApartment($event, room)"
                  >
                    <option value="">0</option>
                    <option
                      :key="a"
                      :data-price="a * room.converted_price"
                      :data-id="room.id"
                      v-for="a in parseInt(room.no_of_rooms)"
                      :value="a"
                      >{{ a }}</option
                    >
                  </select>
                </div>
              </div>
            </div>
          </template>
          <template v-else> </template>

          <div>
            <ul class="list-unstyled mb-0 p-2">
              <li class="d-flex justify-content-between mb-2 lh-22">
                <p class="text-gray-light mb-0">{{ 0 }}</p>
                <p class="font-weight-500 text-heading mb-0">nights</p>
              </li>
              <li class="d-flex justify-content-between mb-2 lh-22">
                <p class="text-gray-light mb-0">Apartment</p>
                <p class="font-weight-500 text-heading mb-0">{{ aps }}</p>
              </li>
            </ul>
          </div>
          <div
            class="card-footer p-2  bg-transparent d-flex justify-content-between p-0 align-items-center"
          >
            <p class="text-heading mb-0">Total Price:</p>
            <span class="fs-32 font-weight-bold text-heading total-price"
              >{{ property.currency }}{{ total }}</span
            >
          </div>
          <button
            type="submit"
            class="ml-1 btn btn-primary btn-round  mr-1 btn-block"
          >
            <div class="auth-spinner d-none">
              <div class="lds-ellipsis">
                <div style="background: rgb(255, 255, 255);"></div>
                <div style="background: rgb(255, 255, 255);"></div>
                <div style="background: rgb(255, 255, 255);"></div>
                <div style="background: rgb(255, 255, 255);"></div>
              </div>
            </div>
            <span class="lt">Reserve</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Persons from "../persons/Persons.vue";
import Guests from "../properties/Guests.vue";
import DateRange from "../properties/Date.vue";

import Pickr from "vue-flatpickr-component";
import axios from "axios";

export default {
  props: {
    apartments: Array,
    property: Object,
  },

  data() {
    return {
      roomsAvailable: [],
      total: 0,
      aps: 0,
      totalRooms: 0,
      apartment_bed_rooms: 0,
      attrPrice: 0,
      checkedAttr: [],
      guests: 0,
      form: {
        room_quantity: [],
        selectedRooms: [],
      },
      date: null,
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
    this.roomsAvailable = this.apartments;
  },
  components: {
    Persons,
    Pickr,
    Guests,
    DateRange,
  },
  methods: {
    getApartmentAvailability() {
      console.log(this.date, "one");
      if (this.date) {
        let date_range = this.date;
        axios
          .post("/check/apartment/availablility", {
            range: date_range,
            property_id: this.property.id,
          })
          .then((response) => {
            this.submiting = false;
          })
          .catch((error) => {});
      }
    },

    check(e) {
      let extra_services = document.querySelectorAll(
        '[name="extra_services[]"]'
      );
      let attr = [];
      extra_services.forEach((e, i) => {
        if (e.checked) {
          attr.push(e.dataset.price);
        }
      });

      this.attrPrice = this.sum(attr);
    },
    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },
    getApartment(e, ap) {
      this.guests = ap.max_adults + ap.max_children;
      this.apartment_bed_rooms = ap.no_of_rooms;

      let qty = e.target.value;
      this.totalRooms = 0;
      let selectApartmentQty = document.querySelectorAll(".room-q");
      let allSelectedRooms = [];
      let total = [];
      selectApartmentQty.forEach((e, i) => {
        if (e.value != "") {
          allSelectedRooms.push(e.value);
          total.push(e.selectedOptions[0].dataset.price || 0);
        }
      });

      this.aps = this.sum(allSelectedRooms);
      this.total = this.sum(total);

      if (this.form.selectedRooms.findIndex((x) => x.id == ap.id) == -1) {
        this.form.selectedRooms.push(ap);
      } else {
        this.form.selectedRooms.forEach((o, i) => {
          if (o.id == apartment.id) {
            this.form.selectedRooms.splice(i, 1);
          }
        });
      }

      // Turn on extra services
    },
  },
};
</script>
