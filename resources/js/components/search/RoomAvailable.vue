<template>
  <div class="">
    <form :action="'/book/' + property.slug" method="GET" class="form-group">
      <input type="hidden" name="_token" :value="$root.token" />
      <input type="hidden" name="property_id" :value="property.id" />
      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group mb-4">
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
                v-model="date"
                :config="config"
                class="form-control"
                placeholder="Check in - Check out"
                name="date"
                @on-change="getApartmentAvailability"
              />
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <button
            class="btn btn-secondary btn-block  pb-2 pt-2 "
            type="button"
            id=""
            aria-haspopup="true"
            aria-expanded="false"
            @click="dropDownToggle()"
          >
            <i class="fal fa-users"></i> {{ guests }} Guests -
            {{ apartment_bed_rooms }} Rooms
          </button>
        </div>
      </div>
      <div v-if="apartments" class="availability">
        <div v-for="apartment in apartments" :key="apartment.id" class="rooms">
          <div class="card mb-3" style="">
            <div class="row no-gutters">
              <div class="col-md-3">
                <img
                  :src="apartment.images[0].image_m"
                  class="img-fluid"
                  :alt="apartment.name"
                />
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <h5 class="card-title">{{ apartment.name }}</h5>
                  <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                    {{ apartment.currency }}{{ apartment.converted_price }}
                    <span class="fs-14 font-weight-500 text-gray-light">
                      /night</span
                    >
                  </p>
                  <div class="card-text">
                    <small href=""
                      >{{ apartment.max_adults + apartment.max_children }}
                      Guests,
                      {{ apartment.no_of_rooms }} bedroom</small
                    >
                  </div>
                  <div class="facility"></div>
                  <div class="">
                    <div>Includes</div>
                  </div>
                </div>
              </div>

              <div
                class="col-md-2 d-flex flex-grow-1 align-items-center justify-content-end"
              >
                <input
                  v-if="property.type == 'single'"
                  type="hidden"
                  :name="'apartment_quantity[' + apartment.uuid + ']'"
                  value="1"
                />
                <div v-if="property.type != 'single'">
                  <select
                    class="form-control a-quantity border-0 shadow-none form-control-lg selectpicker"
                    :name="'apartment_quantity[' + apartment.uuid + ']'"
                    title="0"
                    data-style="btn-lg py-2 h-52"
                    @change="getApartment($event, apartment)"
                  >
                    <option value="0">0</option>
                    <option
                      :key="a"
                      :data-price="a * apartment.converted_price"
                      :data-id="apartment.id"
                      v-for="a in parseInt(apartment.no_of_rooms)"
                      :value="a"
                      >{{ a }} X {{ a * apartment.converted_price }}</option
                    >
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="d-grid gap-2">
          <div
            class="card-footer bg-transparent d-flex justify-content-between p-0 align-items-center"
          >
            <p class="text-heading mb-0">{{ aps }} Apartments</p>
            <span class="fs-32 font-weight-bold text-heading"
              >{{ property.currency }}{{ total }}</span
            >
          </div>
          <button class="btn  btn-primary btn-block" type="submit">
            Book Now
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Persons from "../persons/Persons.vue";
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
      },
    };
  },
  created() {
    this.total =
      this.property.type == "single" ? this.apartments[0].converted_price : 0;
    this.aps = this.property.type == "single" ? 1 : 0;

    this.guests =
      this.property.type == "single"
        ? this.apartments[0].max_adults + this.apartments[0].max_children
        : 0;
    this.apartment_bed_rooms =
      this.property.type == "single" ? this.apartments[0].no_of_rooms : 0;
  },
  components: {
    Persons,
    Pickr,
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
      let selectApartmentQty = document.querySelectorAll(".selectpicker");
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
