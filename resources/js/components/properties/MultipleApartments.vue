<template>
  <div class="">
    <form
      id="multiple-form"
      :action="'/book/' + property.slug"
      method="GET"
      class="form-group"
    >
      <input type="hidden" name="_token" :value="$root.token" />
      <input type="hidden" name="property_id" :value="property.id" />
      <div>
        <h3>Choose your unit</h3>
        <div class="form-row">
          <div
            class="form-group ml-1 form-border cursor-pointer search col-md-4 bmd-form-group"
          >
            <label class="pl-2 ml-4 " for="flatpickr-input-f"
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
          <div id="people-number" class="col-md-4 cursor-pointer">
            <guests />
          </div>
          <div class="col-md-3">
            <button
              type="button"
              @click.prevent="checkAvailabity()"
              class="btn btn-primary btn-block"
            >
              <i class="material-icons">search</i> Check availablity
            </button>
          </div>
        </div>
      </div>
      <div
        id=""
        v-if="!propertyLoading && !roomsAv.length"
        class="name mt-1 rounded bg-white p-2"
      >
        <div class="text-muted text-danger">
          There are not available apartmnets for your search.
        </div>
      </div>

      <div
        :class="{ 'header-filter': propertyLoading }"
        id=""
        class="name mt-1 rounded bg-white p-2"
      >
        <div class="position-relative">
          <input type="hidden" name="property_id" value="217" />

          <template v-if="roomsAv.length">
            <div
              v-for="room in roomsAv"
              :key="room.id"
              :room="room"
              class="row border-bottom  mb-1 mt-1 pl-1 pb-1"
            >
              <div class="col-md-3 position-relative">
                <div>
                  <img :src="room.image_m" class="img  img-fluid" />
                </div>
              </div>
              <div class="col-md-7">
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
                  <div v-if="room.property.is_refundable">Fully Refundable</div>
                </div>
              </div>
              <div
                v-if="stays && stays[1] != null"
                class="col-md-2 position-relative"
              >
                <div class="form-group ">
                  <label for="qty">Qty</label>
                  <select
                    :name="'apartment_quantity[' + room.uuid + ']'"
                    class="form-control room-q"
                    @change="getApartmentQuantity($event, room)"
                  >
                    <option value="">0</option>
                    <option
                      :key="a"
                      :data-sale="2"
                      :data-price="a * room.display_price"
                      :data-id="room.id"
                      v-for="a in parseInt(room.no_of_rooms)"
                      :value="a"
                      >{{ a }}</option
                    >
                  </select>
                  <small v-if="qty" class="text-danger"
                    >Please select one or more option you want to book</small
                  >
                </div>
              </div>
            </div>
          </template>

          <div>
            <ul class="list-unstyled mb-0 p-2">
              <li class="d-flex justify-content-between mb-2 lh-22">
                <p v-if="stays" class="text-gray-light mb-0">
                  {{ stays[0] }} {{ stays[1] || "night" }}
                </p>
                <p v-if="!stays">Choose dates</p>
                <p class="font-weight-500 text-heading mb-0">
                  {{ property.currency }}{{ total }}
                </p>
              </li>
              <li class="d-flex justify-content-between mb-2 lh-22">
                <p class="text-gray-light mb-0">Apartment(s)</p>
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
            v-if="stays && stays[1] != null"
            type="button"
            @click.prevent="reserve()"
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
import Guests from "../properties/Guests.vue";
import Apartment from "./Apartment.vue";

import Pickr from "vue-flatpickr-component";
import axios from "axios";

export default {
  props: {
    apartments: Array,
    property: Object,
    propertys_not_available: Array,
    nights: Array,
  },
  data() {
    return {
      roomsAvailable: [],
      roomsAv: [],
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
    this.properties_not_available = this.propertys_not_available;
    this.roomsAv = this.apartments;
  },
  components: {
    Pickr,
    Guests,
    Apartment,
  },
  methods: {
    checkAvailabity() {
      this.form.children = document.querySelector("#children").value;
      this.form.adults = document.querySelector("#adults").value;
      this.form.rooms = document.querySelector("#rooms").value;
      if (!this.form.check_in_checkout) {
        this.$refs.datePicker.fp.open();
        return;
      }

      this.propertyLoading = true;
      axios
        .post("/check/apartment/availablility", this.form)
        .then((response) => {
          this.roomsAv = response.data.data;
          this.stays = response.data.nights;
          this.propertyLoading = false;
        })
        .catch((error) => {});
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
    getApartmentQuantity(e, ap) {
      this.guests = ap.max_adults + ap.max_children;
      this.apartment_bed_rooms = ap.no_of_rooms;
      this.qty = false;

      let qty = e.target.value;
      this.totalRooms = 0;
      let selectApartmentQty = document.querySelectorAll(".room-q");
      let allSelectedRooms = [];
      let total = [];

      var checked = [];
      let filters = {};
      selectApartmentQty.forEach((e, i) => {
        if (e.value != "") {
          allSelectedRooms.push(e.value);
          total.push(e.selectedOptions[0].dataset.price || 0);
        }

        filters = {
          [ap.id]: e.value,
        };
        checked.push(filters);
      });
      console.log(checked);

      this.aps = this.sum(allSelectedRooms);
      this.total = this.sum(total) * parseInt(this.stays[0]);
      if (this.form.selectedRooms.findIndex((x) => x.id == ap.id) == -1) {
        this.form.selectedRooms.push(ap);
      } else {
        this.form.selectedRooms.forEach((o, i) => {
          if (o.id == ap.id) {
            this.form.selectedRooms.splice(i, 1);
          }
        });
      }

      // Turn on extra services
    },
    reserve(e) {
      if (!this.form.check_in_checkout) {
        this.$refs.datePicker.fp.open();
        return false;
      }
      if (this.total < 1) {
        this.qty = true;
        return false;
      }

      let selectApartmentQty = document.querySelectorAll(".room-q");
      var checked = [];
      let filters = {};
      selectApartmentQty.forEach((e, i) => {
        if (e.value != "") {
          filters = {
            [e.selectedOptions[0].dataset.id]: e.value,
          };
          checked.push(filters);
        }
      });
      let form = {
        apartment_quantity: checked,
        property_id: this.property.id,
        check_in_checkout: this.form.check_in_checkout,
      };

      this.propertyLoading = true;
      axios
        .post("/book/store", form)
        .then((response) => {
          document.querySelector("#multiple-form").submit();
        })
        .catch((error) => {
          alert("We could not make your reservation.Please try again later");
        });
    },
  },
};
</script>
