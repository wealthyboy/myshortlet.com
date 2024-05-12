<template>
  <div class="">
    <form id="multiple-form" :action="'/book/' + property.slug" method="GET" class="form-group">
      <input type="hidden" name="_token" :value="$root.token" />
      <input type="hidden" name="property_id" :value="property.id" />
      <div>
        <h3 class="bold-2">Choose your unit</h3>
        <div class="form-row">
          <div class="form-group   form-border cursor-pointer search col-md-5 bmd-form-group  mb-sm-2 mb-md-0">
            <label class="pl-2 " for="flatpickr-input-f">Check-in - Check-out</label>
            <date :isDateNeedsToToOpen="isDateNeedsToToOpen" @dateSelected="dateSelected" />
          </div>
          <div id="people-number" class="col-md-5 cursor-pointer px-sm-0 px-md-1">
            <guests />
          </div>
          <div class="col-md-2 check-availablility  mt-sm-2 mt-md-0">
            <button type="button" @click.prevent="checkAvailabity()"
              class="btn btn-primary btn-block m-auto bold-2 check-availablility-button rounded">
              Check availablitybnnbnbnb
            </button>
          </div>
        </div>
      </div>
      <div id="" v-if="!propertyLoading && !roomsAv.length" class="name mt-1 rounded bg-white p-2">
        <div class="text-muted text-danger">
          {{
            error_msg || "There are not available apartments for your search."
          }}
        </div>
      </div>

      <div :class="{ 'header-filter': propertyLoading }" id="" class="name mt-1 rounded p-2">
        <div class="position-relative">
          <input type="hidden" name="property_id" value="217" />
          <template v-if="roomsAv.length">
            <div class="row">
              <apartments @reserve="reserve" :amenities="amenities" @qtyChange="getApartmentQuantity"
                v-for="room in roomsAv" :key="room.id" :room="room" :stays="stays" :qty="qty" />
            </div>
          </template>

          <!-- <div>
            <ul class="list-unstyled mb-0 p-2">
              <li class="d-flex justify-content-between mb-2 lh-22">
                <p v-if="stays" class="text-gray-light mb-0 bold-2">
                  {{ stays[0] || 0 }} {{ stays[1] || "night" }}
                </p>
                <p v-if="!stays">Choose dates</p>
                <p class="bold-2 text-heading mb-0">
                  {{ property.currency }}{{ total | priceFormat }}
                </p>
              </li>
              <li class="d-flex justify-content-between mb-2 lh-22">
                <p class="text-gray-light mb-0 bold-2">{{ aps }} Apartment(s)</p>
                <p class="bold-2 text-heading mb-0">
                  {{ property.currency }}{{ apTotal | priceFormat }}
                </p>
              </li>
            </ul>
          </div> -->

          <!-- <div class="card-footer p-2  bg-transparent d-flex justify-content-between p-0 align-items-center">
            <p class="text-heading mb-0 bold-2">Total Price:</p>
            <span class="fs-32 bold-2 text-heading total-price">{{ property.currency }}{{ amount | priceFormat }}</span>
          </div> -->
          <!-- <button v-if="stays && stays[1] != null" type="button" @click.prevent="reserve()"
            class="ml-1 btn btn-primary btn-round  mr-1 btn-block">
            <div class="auth-spinner d-none">
              <div class="lds-ellipsis">
                <div style="background: rgb(255, 255, 255);"></div>
                <div style="background: rgb(255, 255, 255);"></div>
                <div style="background: rgb(255, 255, 255);"></div>
                <div style="background: rgb(255, 255, 255);"></div>
              </div>
            </div>
            <span class="lt">Reserve</span>
          </button> -->
        </div>
      </div>
    </form>

    <div class="modal-overlay ">
      <div class="modal ">
        <div class="modal-content">
          <!-- Your modal content here -->
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus euismod ultrices velit, nec cursus ipsum
            tincidunt ut.</p>
          <!-- Add more content as needed -->
        </div>
      </div>
    </div>


  </div>
</template>
<script>
import Guests from "../properties/Guests.vue";
import Apartments from "./Apartments.vue";
import Date from "./Date.vue";
import Pickr from "vue-flatpickr-component";
import axios from "axios";

export default {
  props: {
    apartments: Array,
    property: Object,
    propertys_not_available: Array,
    nights: Array,
    amenities: Array,
    isAgent: Boolean
  },
  data() {
    return {
      roomsAv: [],
      total: 0,
      aps: 0,
      apTotal: 0,
      attrPrice: 0,
      guests: 0,
      amount: 0,
      apQ: [],
      qty: false,
      stays: null,
      loading: false,
      propertyLoading: false,
      isDateNeedsToToOpen: false,
      error_msg: null,
      form: {
        room_quantity: [],
        selectedRooms: [],
        children: null,
        adults: null,
        rooms: null,
        check_in_checkout: null,
        property_id: this.property.id,
      },
    };
  },
  created() {
    console.log(this.apartments)
    this.stays = this.nights;
    this.roomsAv = this.apartments;
  },
  mounted() {

    // Show the modal

    const retrievedJsonString = localStorage.getItem('searchParams');
    // Check if the retrieved JSON string is not null
    if (retrievedJsonString !== null) {
      const retrievedObject = JSON.parse(retrievedJsonString);
      this.form.check_in_checkout = retrievedObject.check_in_checkout
      this.checkAvailabity()
    }


    jQuery(function () {
      $(".owl-carousel").owlCarousel({
        margin: 10,
        nav: true,
        dots: false,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 1,
          },
          1000: {
            items: 1,
          },
        },
      });
    });
  },
  components: {
    Pickr,
    Guests,
    Apartments,
    Date,
  },
  methods: {
    dateSelected(value) {
      this.form.check_in_checkout = value;
    },
    checkAvailabity() {
      console.log(true)
      this.form.children = document.querySelector("#children").value;
      this.form.adults = document.querySelector("#adults").value;
      this.form.rooms = document.querySelector("#rooms").value;
      if (
        !this.form.check_in_checkout ||
        this.form.check_in_checkout.split(" ").length < 2
      ) {
        this.isDateNeedsToToOpen = true;
        return;
      }
      this.propertyLoading = true;
      axios
        .post("/check/apartment/availablility", this.form)
        .then((response) => {
          this.roomsAv = response.data.data;
          this.stays = response.data.nights;
          this.propertyLoading = false;
          jQuery(function () {
            $(".room-carousel").owlCarousel({
              margin: 10,
              nav: true,
              dots: false,
              responsive: {
                0: {
                  items: 1,
                },
                600: {
                  items: 1,
                },
                1000: {
                  items: 1,
                },
              },
            });
          });
        })
        .catch((error) => { });
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
    getApartmentQuantity({ total, aps }) {
      console.log(total, aps)
      this.total = total;
      this.aps = aps;
      this.apTotal = total;
      this.amount = this.apTotal;
    },
    reserve(room) {
      let ap = room.room
      if (
        !this.form.check_in_checkout ||
        this.form.check_in_checkout.split(" ").length < 2
      ) {
        this.isDateNeedsToToOpen = true;
        return;
      }


      let selectApartmentQty = document.querySelectorAll(".room-q");
      var checked = [];
      let filters = {};

      filters = {
        [this.property.id]: ap.id,
      };

      console.log(filters);
      checked.push(filters);

      let form = {
        apartment_quantity: checked,
        propertyId: this.property.id,
        apID: ap.id,
        check_in_checkout: this.form.check_in_checkout,

      };

      this.propertyLoading = true;

      axios
        .post("/book/store", form)
        .then((response) => {
          this.propertyLoading = false;
          if (response.data) {
            document.querySelector("#multiple-form").submit();
          } else {
            this.error_msg =
              "It seems we could not further your request .Try a diffrent date.";
            this.roomsAv = [];
          }
        })
        .catch((error) => {
          this.error_msg =
            "It seems we could not further your request .Try a diffrent date.";
        });
    },
  },
};
</script>

