<template>
  <div class="col-12 col-md-4 border-bottom  mb-1 mt-1 pl-1 pb-1 px-0">
    <div class="col-md-12 aprts position-relative p-0">
      <div class="owl-carousel owl-theme">
        <div class="item rounded-top" :key="image.id" v-for="image in room.images">
          <img :src="image.image" class="img   img-fluid" />
          <div class="images-count">
            <button type="button"
              class="uitk-button uitk-button-medium uitk-button-has-text uitk-button-overlay uitk-gallery-button">
              <svg class="uitk-icon uitk-icon-leading uitk-icon-medium"
                aria-label="Show all 7 images for Classic Twin Room" role="img" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title id="photo_library-property-offers-media-carousel-1-title">Show all {{ room.images.length }} images
                </title>
                <path fill-rule="evenodd"
                  d="M22 16V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2zm-11-4 2.03 2.71L16 11l4 5H8l3-4zm-9 8V6h2v14h14v2H4a2 2 0 0 1-2-2z"
                  clip-rule="evenodd"></path>
              </svg><span aria-hidden="true">{{ room.images.length }}</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 bg-white  pt-3">
      <div class="card-title bold-2 text-size-1-big  mt-lg-0 mt-sm-3 ">
        <a @click.prevent="showRoom(room)" :href="`/apartment/${room.slug}`">{{ room.name }}</a>
      </div>
      <div class="text-size-2 text-gold">
        <i class="fas fa-info-circle mr-2 "></i>Instant Confirmation
      </div>
      <div class="entire-apartments">
        <div class="bold-2 mb-2">Entire apartment</div>
        <div class="d-flex justify-content-between flex-wrap flex-column">
          <div class="position-relative mb-1">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#bedrooms-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.no_of_rooms }} Bedrooms</span>
          </div>
          <div class="position-relative mb-1">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#bathroom-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.toilets }} bathrooms</span>
          </div>
          <div class="position-relative mb-1">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#sleeps-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.guests }} Guests</span>
          </div>
        </div>

        <div v-if="room.free_services.length" class="d-inline-flex flex-wrap">
          <div v-for="free_service in room.free_services" :key="free_service.id" class="position-relative">
            <span class="position-absolute svg-icon-section "></span>
            <span class="svg-icon-text text-gray">{{ free_service.name }}</span>
          </div>
        </div>

        <template v-if="room.bedrooms.length">
          <div v-for="bed in room.bedrooms" :key="bed.id" class="position-relative mb-1">
            <span class="position-absolute svg-icon-section">
              <svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <path fill-rule="evenodd" d="M11 7h8a4 4 0 014 4v9h-2v-3H3v3H1V5h2v9h8V7zm-1 3a3 3 0 11-6 0 3 3 0 016 0z"
                  clip-rule="evenodd"></path>
              </svg>
            </span>
            <span class="svg-icon-text">{{ bed.parent.name }}</span>
            <span class="svg-icon-text">
              {{ bed.pivot.bed_count }} {{ bed.name }}
            </span>
          </div>
        </template>

        <div class="position-relative mb-1">
          <a @click.prevent="showRoom(room)" class="d-flex active-link text-highlight font-weight-bold-2" href="#">
            <span aria-hidden="true">More details</span>
            <svg class="" aria-hidden="true" class="align-self-center" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <path d="M10 6 8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"></path>
            </svg>
          </a>
        </div>
      </div>

      <div>
        <div class="d-flex d-flex justify-content-between">
          <div class="price-box ">
            <div class="d-inline-flex  mt-sm-3">
              <template v-if="room.discounted_price">
                <div class="sale-price mr-3">
                  {{ room.currency }}{{ room.converted_price | priceFormat }}
                </div>
                <div class="price bold-3">
                  {{ room.currency }}{{ room.discounted_price | priceFormat }}
                </div>
              </template>
              <template v-else>
                <div class="price bold-3 mt-2">
                  {{ room.currency }}{{ room.converted_price | priceFormat }}
                </div>
              </template>
            </div>
            <div class="text-size-2">{{ room.price_mode }}</div>
          </div>
          <div class="align-self-end">
            <div class="font-weight-bold-2 text-success" v-if="room.property.is_refundable">
              Fully Refundable
            </div>
            <a target="_blank" @click.prevent="reserve(room)"
              class="btn btn-round  btn-blue   py-2  bold-2   align-self-end font-weight-bold-2">
              Book now
            </a>
          </div>
        </div>
      </div>
    </div>

    <div v-if="stays && stays[1] != null" class="col-md-12 position-relative bg-white"> 
      <div class="form-group ">
        <template v-if="room.reservation_qty && room.quantity == room.reservation_qty">
          <div class="text-muted ">
            This apartment is not available for your seclected date
          </div>
        </template>
      </div>
    </div>

    <div v-if="lunchModal" class=" gallery-images" style="
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
        cursor: pointer;">
      <div class="container">
        <div class="">
          <div class="py-2  border-bottom">
            <h3 class="bold-2">Apartment Information</h3>

            <button @click="lunchModal = !lunchModal" style="z-index: 1; right:10px; top: 15px"
              class="close-icon  cursor-pointer fa-1x position-absolute raised">
              <i class="fal fa-times"></i>
            </button>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-4">
            <div class="card-title  bold-2 text-size-1-big">
              <a @click.prevent="showRoom(room)" href="#">{{ room.name }}</a>
            </div>
            <div class="d-flex  flex-column">
              <div class="position-relative mb-2">
                <span class="position-absolute svg-icon-section">
                  <svg>
                    <use xlink:href="#bedrooms-icon"></use>
                  </svg>
                </span>
                <span class="svg-icon-text">{{ room.no_of_rooms }} Bedrooms</span>
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
              <h4 class="card-title bold-2 text-size-1-big">
                Amenities
              </h4>
              <div :key="amenity.id" v-for="(amenity, index) in amenities">
                <div class="">
                  <div class="bold-2">
                    {{ index }}
                  </div>
                  <div v-for="facility in  amenity" class="svg-icon-text">{{ facility.name }} </div>
                </div>

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
    amenities: Array,
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
  },
  components: {},
  methods: {
    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },
    showRoom(room) {
      this.lunchModal = !this.lunchModal;
      this.showSlider = true;
      jQuery(function () {
        $(".room-carousel").owlCarousel({
          margin: 10,
          nav: true,
          dots: true,
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
    reserve(room) {
      this.$emit("reserve", { room });
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
