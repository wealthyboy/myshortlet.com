<template>
  <div
    :class="classType"
    class="mb-1 mt-1 pl-1 pb-1 px-0"
    itemscope
    itemtype="https://schema.org/HotelRoom"
  >
    <div
      class="col-md-12 small aprts position-relative p-0"
      itemscope
      itemtype="https://schema.org/ImageGallery"
    >

      <div class="owl-carousel owl-theme">

        <div
          v-if="room.image"
          class="item  rounded-top"
          itemprop="photo"
          
          itemscope
          itemtype="https://schema.org/ImageObject"
        >
          <img
            :alt="room.name"

            :title="'book ' + room.name + '  Avenue Montaigne'"
            @click.prevent="showRoom(room)"
            :src="room.image"
            class="img cursor-pointer img-fluid"
            itemprop="contentUrl"
          />


        
          <div class="images-count">
            <button
              role="button"
              type="button"
              class="uitk-button uitk-button-medium uitk-button-has-text uitk-button-overlay uitk-gallery-button"
            >
              <svg
                class="uitk-icon uitk-icon-leading uitk-icon-medium"
                aria-label="Show all images "
                role="img"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
              >
                <title
                  id="photo_library-property-offers-media-carousel-1-title"
                >
                  Show all
                  {{
                    room.images_count 
                  }}
                  images
                </title>
                <path
                  fill-rule="evenodd"
                  d="M22 16V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2zm-11-4 2.03 2.71L16 11l4 5H8l3-4zm-9 8V6h2v14h14v2H4a2 2 0 0 1-2-2z"
                  clip-rule="evenodd"
                ></path></svg
              ><span
                @click.prevent="showRoom(room)"
                class="cursor-pointer"
                role="button"
                aria-hidden="true"
                >{{
                  room.images_count 
                }}
                View </span
              >
            </button>
          </div>
        </div>
        <div
          class="item rounded-top"
          :key="index"
          v-for="(image, index) in room.image_links"
          itemprop="photo"
          itemscope
          itemtype="https://schema.org/ImageObject"
        >
          <img
            :alt="room.name"
            :title="'book ' + room.name + '  Avenue Montaigne'"
            @click.prevent="showRoom(room)"
            :src="image.image"
            class="img cursor-pointer img-fluid"
            itemprop="contentUrl"
          />

          <div
              class="image-caption position-absolute"
              v-if="image.caption"
            >
              {{ image.caption}} 
          </div>
          <div class="images-count">
            <button
              role="button"
              type="button"
              class="uitk-button uitk-button-medium uitk-button-has-text uitk-button-overlay uitk-gallery-button"
            >
              <svg
                class="uitk-icon uitk-icon-leading uitk-icon-medium"
                aria-label="Show all images "
                role="img"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
              >
                <title
                  id="photo_library-property-offers-media-carousel-1-title"
                >
                  Show all
                  {{
                    room.images_count 
                  }}
                  images
                </title>
                <path
                  fill-rule="evenodd"
                  d="M22 16V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2zm-11-4 2.03 2.71L16 11l4 5H8l3-4zm-9 8V6h2v14h14v2H4a2 2 0 0 1-2-2z"
                  clip-rule="evenodd"
                ></path></svg
              ><span
                @click.prevent="showRoom(room)"
                class="cursor-pointer"
                role="button"
                aria-hidden="true"
                >{{
                  room.images_count  
                }}

                View All</span
              >
            </button>
          </div>
        </div>


         <div v-if="room.video" class="item rounded-top video-wrapper">
            <div 
                v-if="!isPlaying" 
                class="video-preview cursor-pointer"
                @click="initVideo"
              >
                <img 
                  :src="room.image_links[0].image"
                  class="img-fluid rounded-top w-100"
                  alt="video preview"
                />

                <div class="video-play-btn">
                  ▶
                </div>
            </div>

            <video
              v-show="isPlaying"
              ref="videoPlayer"
              playsinline
              preload="metadata"
              controls
              class="w-100 rounded-top custom-video"
            ></video>

        </div>
      </div>
    </div>
    <div class="col-md-12 bg-white aprt-content pt-3 pb-2">
      <div
        class="card-title d-flex justify-content-between align-items-center bold-2 text-size-1-big mt-sm-3 mt-3"
        itemprop="name"
      >
        <a :href="`/apartment/${room.slug}/`">{{ room.name }}</a>

        <span v-if="room.video" class="video-pill d-flex align-items-center ml-2">
          <svg
            width="14"
            height="14"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            <path
              d="M3 5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l4 4V7l-4 4V7a2 2 0 0 0-2-2H3z"
              fill="currentColor"
            />
            <path d="M10 8.5v7l5-3.5-5-3.5z" fill="#fff" />
          </svg>
          <span class="text-small">Video included in the slide</span>
        </span>

        <a  
          v-if="room.is_gallery"
          target="_blank"
          :href="`/apartment/${room.id}/download-images`"
          class="btn btn-round btn-primary py-2 bold-2 text-white"
        >
          Download
        </a>
      </div>
      <div
        v-if="!room.is_gallery"
        class="text-size-2 text-gold"
        itemprop="amenityFeature"
        itemscope
        itemtype="https://schema.org/LocationFeatureSpecification"
      >
        <i class="fas fa-info-circle mr-2"></i
        ><span itemprop="name">Instant Confirmation</span>
      </div>
      <div :class="{ 'h-25': room.is_gallery }" class="entire-apartments h-25">
        <div v-if="!room.is_gallery" class="bold-2 mb-2" itemprop="description">
          Entire apartment
        </div>
        <div
          v-if="!room.is_gallery"
          class="d-flex justify-content-between flex-wrap flex-column"
        >
          <div class="position-relative mb-1" itemprop="numberOfRooms">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#bedrooms-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.no_of_rooms }} Bedrooms</span>
          </div>
          <div class="position-relative mb-1" itemprop="numberOfBathroomsTotal">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#bathroom-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.toilets }} bathrooms</span>
          </div>
          <div
            class="position-relative mb-1"
            itemprop="occupancy"
            itemscope
            itemtype="https://schema.org/QuantitativeValue"
          >
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#sleeps-icon"></use>
              </svg>
            </span>
            <span class="svg-icon-text" itemprop="value">{{
              room.max_adults
            }}</span>
            Guests
          </div>
          <div class="position-relative mb-1" itemprop="floorLevel">
            <span class="position-absolute svg-icon-section">
              <svg>
                <use xlink:href="#location_city"></use>
              </svg>
            </span>
            <span class="svg-icon-text">{{ room.floor }}</span>
          </div>
        </div>
        <template v-if="!room.is_gallery && room.no_of_rooms">
          <div
            v-for="index in room.no_of_rooms"
            :key="index"
            class="position-relative mb-1"
            itemprop="bed"
            itemscope
            itemtype="https://schema.org/BedDetails"
          >
            <span class="position-absolute svg-icon-section">
              <svg
                aria-hidden="true"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M11 7h8a4 4 0 014 4v9h-2v-3H3v3H1V5h2v9h8V7zm-1 3a3 3 0 11-6 0 3 3 0 016 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </span>
            <span class="svg-icon-text" itemprop="type"
              >Bedroom </span
            >
            <span class="svg-icon-text">
              <!-- Assuming room has dynamic properties like bedroom_1, bedroom_2 -->
              {{ room["bedroom_" + index] }}
            </span>
          </div>
        </template>
      </div>

      <div v-if="!room.is_gallery">
        <div class="d-flex d-flex justify-content-between">
          <div
            class="price-box"
            itemprop="offers"
            itemscope
            itemtype="https://schema.org/Offer"
          >
            <div class="d-inline-flex mt-sm-3">
              <template v-if="room.discounted_price">
                <div class="sale-price mr-3" itemprop="price">
                  {{ room.currency }}{{ room.converted_price | priceFormat }}
                </div>
                <div class="price bold-3" itemprop="price">
                  {{ room.currency }}{{ room.discounted_price | priceFormat }}
                </div>
              </template>
              <template v-else>
                <div class="price bold-3 mt-2" itemprop="price">
                  {{ room.currency }}{{ room.converted_price | priceFormat }}
                </div>
              </template>
            </div>
            <div class="text-size-2" itemprop="priceCurrency">
              {{ room.price_mode }}
            </div>
          </div>
          <div class="align-self-end">
            <div
              class="font-weight-bold-2 text-success"
              v-if="room.is_refundable"
            >
              Fully Refundable 
            </div>
            <a
              target="_blank"
              v-if="showReserve"
              @click.prevent="reserve(room)"
              class="btn btn-round btn-primary py-2 bold-2 text-white align-self-end font-weight-bold-2"
              itemprop="url"
            >
              Book now
            </a>
          </div>
        </div>
      </div>
    </div>
    <div v-if="!room.is_gallery">
      <div
        v-if="stays && stays[1] != null"
        class="col-md-12 position-relative bg-white"
      >
        <div class="form-group">
          <template
            v-if="room.reservation_qty && room.quantity == room.reservation_qty"
          >
            <div class="text-muted">
              This apartment is not available for your selected date
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import Hls from "hls.js";

export default {
  props: {
    property: Object,
    room: Object,
    propertyLoading: Boolean,
    stays: Array,
    qty: Boolean,
    amenities: Array,
    classType: Array,
    showReserve: Boolean,
    isGallery: Number,

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
      isPlaying: false,
      src: "",
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

    const video = this.$refs.videoPlayer;

    console.log(this.room)
          this.src = "https://avevuemontaigne-ng.lon1.cdn.digitaloceanspaces.com/" + this.room.video.encoded_path;



    // if (Hls.isSupported()) {
    //   const hls = new Hls({
    //     capLevelToPlayerSize: true, // pick best resolution for screen
    //     maxBufferLength: 30,        // max buffer length in seconds
    //     autoStartLoad: true
    //   });

    //   hls.loadSource(this.src);      // master.m3u8 URL
    //   hls.attachMedia(video);

    //   hls.on(Hls.Events.MANIFEST_PARSED, () => {
    //     video.play();
    //   });

    //   // Optional: log quality levels
    //   hls.on(Hls.Events.LEVEL_LOADED, (event, data) => {
    //     console.log('Available qualities:', data.levels.map(l => l.height));
    //   });

    // } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
    //   // Safari/iOS fallback
    //   video.src = this.src;
    //   video.addEventListener("loadedmetadata", () => {
    //     video.play();
    //   });
    // } else {
    //   console.error("HLS not supported in this browser.");
    // } 

    jQuery(function () {
      $(".room-carousel").owlCarousel({
        margin: 10,
        nav: true,
        dots: false,
        navText: [
          '<div class="nav-btn prev-slide d-flex justify-content-center align-items-center mr-1"><svg  viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg"><path d="M19.9 40L1.3 20 19.9 0"  fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
          '<div class="nav-btn next-slide d-flex justify-content-center align-items-center ml-1"><svg  viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg"><path d="M.1 0l18.6 20L.1 40"  fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
        ],
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

    video.addEventListener("pause", () => this.handleVideoStop());
    video.addEventListener("ended", () => this.handleVideoStop());


    $(".owl-carousel").on("changed.owl.carousel", () => {
      if (this.$refs.videoPlayer) {
        this.$refs.videoPlayer.pause();
        this.isPlaying =false

        console.log(this.isPlaying)

        const dots = document.querySelector(".aprts .owl-dots");

          console.log(dots)
          if (dots) {
            dots.classList.remove("video-is-playing");
          }
      }
    });
  },
  components: {},
  computed: {
    // isHomePage() {
    //   return window.location.pathname === "/" || window.location.pathname === "";
    // }
  },
  methods: {
    handleVideoStop() {
        this.isPlaying = false;
        const dots = document.querySelector(".aprts .owl-dots");
        if (dots) {
          dots.classList.remove("video-is-playing");
        }
      },

      // existing methods...

    initVideo() {
      this.isPlaying = true;

      const video = this.$refs.videoPlayer;

      const dots = document.querySelector(".aprts .owl-dots");

      console.log(dots)
      if (dots) {
        dots.classList.add("video-is-playing");
      }
      

      if (Hls.isSupported()) {

        const hls = new Hls({
          capLevelToPlayerSize: true,
          autoStartLoad: true,
        });

        hls.loadSource(this.src);
        hls.attachMedia(video);

        hls.on(Hls.Events.MANIFEST_PARSED, () => {
          video.play();
        });

      } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
        video.src = this.src;
        video.addEventListener("loadedmetadata", () => {
          video.play();
        });
      }
    },

    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },
    showRoom(room) {
      this.$emit("showRoom", room);
    },
    showImages(room) {
      this.$emit("showImages", room);
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
<style scoped>
.video-wrapper {
  position: relative;
  overflow: hidden;
}

.video-preview {
  position: relative;
}

.video-play-btn {
  position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.55);
    color: white;
    font-size: 21px;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    align-content: center;
    align-self: center;
}

.custom-video {
  object-fit: cover;
  height: 233px;
}

.video-pill {
  font-size: small;
  color: brown;
}

</style>
