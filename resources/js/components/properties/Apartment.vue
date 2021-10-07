<template>
  <div class="row border-bottom  mb-1 mt-1 pl-1 pb-1">
    <div class="col-md-3 position-relative">
      <div>
        <img :src="room.image_m" class="img  img-fluid" />
      </div>
    </div>
    <div class="col-md-7">
      <div class="card-title">
        <a href="#">{{ room.name }} {{ propertyLoading }}</a>
      </div>
      <div><i class="fas fa-info-circle mr-2"></i>Instant Confirmation</div>
      <div class="entire-apartment">
        <div>Entire apartment</div>
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
    <div class="col-md-2 position-relative">
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
        <small>Please select one or more option you want to book</small>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    property: Object,
    properties_not_available: Array,
    room: Object,
    propertyLoading: Boolean,
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
      stays: null,
      propertyQty: [],
      form: {
        room_quantity: [],
        selectedRooms: [],
      },
    };
  },
  methods: {
    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
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

      // Turn on extra services
    },
  },
};
</script>
