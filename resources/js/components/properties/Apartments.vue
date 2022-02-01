<template>
  <div class="row border-bottom  mb-1 mt-1 pl-1 pb-1">
    <div class="col-md-3 position-relative">
      <div class="owl-carousel owl-theme">
        <div class="item" :key="image.id" v-for="image in room.images">
          <img :src="image.image_m" class="img  img-fluid" />
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card-title bold text-size-1-big">
        <a @click.prevent="showRoom(room)" href="#">{{ room.name }}</a>
      </div>
      <div class="text-size-2 text-gold">
        <i class="fas fa-info-circle mr-2 "></i>Instant Confirmation
      </div>
      <div class="entire-apartment">
        <div class="bold mb-2">Entire apartment</div>
        <div class="d-flex justify-content-between flex-wrap">
          <div class="position-relative">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#bedrooms-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.no_of_rooms }} Bedrooms</span>
          </div>
          <div class="position-relative">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#bathroom-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.toilets }} bathrooms</span>
          </div>
          <div class="position-relative">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#sleeps-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.guests }} Guests</span>
          </div>
        </div>
      </div>
      <div class="position-relative">
        <span class="position-absolute svg-icon-section"></span>
        <span class="svg-icon-text">Air condition</span>
      </div>

      <div v-if="room.free_services.length" class="d-inline-flex flex-wrap">
        <div
          v-for="free_service in room.free_services"
          :key="free_service.id"
          class="position-relative"
        >
          <span class="position-absolute svg-icon-section "></span>
          <span class="svg-icon-text text-gray">{{ free_service.name }}</span>
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
                {{ room.currency }}{{ room.converted_price | priceFormat }}
              </div>
              <div class="price bold">
                {{ room.currency }}{{ room.discounted_price | priceFormat }}
              </div>
            </template>
            <template v-else>
              <div class="price bold mt-2">
                {{ room.currency }}{{ room.converted_price | priceFormat }}
              </div>
            </template>
          </div>
          <div class="text-size-2">per night</div>
        </div>
        <div v-if="room.property.is_refundable">Fully Refundable</div>
      </div>
    </div>
    <div v-if="stays && stays[1] != null" class="col-md-2 position-relative">
      <div class="form-group ">
        <label for="qty">Qty</label>
        <template
          v-if="room.reservation_qty && room.quantity == room.reservation_qty"
        >
          <div class="text-muted ">
            This apartment is not available for your seclected date
          </div>
        </template>
        <template v-else>
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
              v-for="a in parseInt(room.quantity)"
              :value="a"
              >{{ a }}</option
            >
          </select>
          <small v-if="qty" class="text-danger"
            >Please select one or more option you want to book</small
          >
        </template>
      </div>
    </div>

    <div
      v-if="lunchModal"
      class=" gallery-images"
      style="
        position: fixed; 
        display: block;
        width: 100%; 
        height: 100vh; 
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2090; 
        background-color: #fff;
        cursor: pointer;"
    >
      <div class="container">
        <div class="">
          <div class="p-2 border-bottom">
            <h3 class="bold">Apartment Information</h3>

            <button
              @click="lunchModal = !lunchModal"
              style="z-index: 1; right:10px; top: 15px"
              class="close-icon  cursor-pointer fa-1x position-absolute raised"
            >
              <i class="fal fa-times"></i>
            </button>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-4">
            <div class="card-title  bold text-size-1-big">
              <a @click.prevent="showRoom(room)" href="#">{{ room.name }}</a>
            </div>
            <div class="d-flex  flex-column">
              <div class="position-relative mb-2">
                <span class="position-absolute svg-icon-section">
                  <svg>
                    <use xlink:href="#bedrooms-icon"></use>
                  </svg>
                </span>
                <span class="svg-icon-text"
                  >{{ room.no_of_rooms }} Bedrooms</span
                >
              </div>
              <div class="position-relative mb-2">
                <span class="position-absolute svg-icon-section">
                  <svg>
                    <use xlink:href="#bathroom-icon"></use>
                  </svg>
                </span>
                <span class="svg-icon-text">{{ room.toilets }} bathrooms</span>
              </div>
              <div class="position-relative mb-2">
                <span class="position-absolute svg-icon-section">
                  <svg>
                    <use xlink:href="#sleeps-icon"></use>
                  </svg>
                </span>
                <span class="svg-icon-text">{{ room.guests }} Guests</span>
              </div>
            </div>
            <div class="facilities">
              <h4 class="card-title bold text-size-1-big">
                Amenities
              </h4>
              <div
                :key="apartment_facility.id"
                v-for="apartment_facility in room.apartment_facilities"
              >
                <div>{{ apartment_facility.parent.name }}</div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="room-carousel owl-carousel owl-theme">
              <div class="item" :key="image.id" v-for="image in room.images">
                <img :src="image.image" class="img  img-fluid" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// optional style for arrows & dots

export default {
  props: {
    property: Object,
    room: Object,
    propertyLoading: Boolean,
    stays: Array,
    qty: Boolean,
  },
  data() {
    return {
      total: 0,
      aps: 0,
      totalRooms: 0,
      apartment_bed_rooms: 0,
      attrPrice: 0,
      checkedAttr: [],
      guests: 0,
      sub_total: 0,
      lunchModal: false,
      showSlider: false,
      propertyQty: [],
      apartment_facilities: [],
      settings: {
        dots: true,
        dotsClass: "slick-dots custom-dot-class",
        edgeFriction: 0.35,
        infinite: false,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
      },

      form: {
        room_quantity: [],
        selectedRooms: [],
      },
    };
  },
  mounted() {
    jQuery(function() {
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
  },
  components: {},
  methods: {
    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },
    showRoom(room) {
      this.lunchModal = !this.lunchModal;
      this.showSlider = true;
      jQuery(function() {
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
    },
    getApartmentQuantity(e, ap) {
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

      let aps = this.aps;
      let t = this.total;
      this.$emit("qtyChange", { total: t, aps: aps });
      // Turn on extra services
    },
  },
};
</script>
