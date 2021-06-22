<template>
  <div class="">
    <form :action="'/book/' + apartment.slug" method="GET" class="form-group">
      <input type="hidden" name="_token" :value="$root.token" />
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
              <input
                type="text"
                class="form-control  shadow-none fs-13"
                id="flatpickr-input-f"
                name="check_in_check_out"
                placeholder="Check in-Check out"
              />
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <persons />
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-block btn-primary">
            Search
          </button>
        </div>
      </div>

      <div v-if="roomsAvailable" class="availability">
        <div v-for="room in roomsAvailable" :key="room.id" class="rooms">
          <div class="card mb-3" style="">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img :src="room.image_m" class="img-fluid" alt="..." />
              </div>
              <div class="col-md-6">
                <div class="card-body">
                  <h5 class="card-title">{{ room.name }}</h5>
                  <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                    {{ room.currency }}{{ room.converted_price }}
                    <span class="fs-14 font-weight-500 text-gray-light">
                      /night</span
                    >
                  </p>
                  <div class="card-text">
                    <small href=""
                      >3 adults max , 2 Children Max, 3 bedroom</small
                    >
                  </div>
                  <div class="facility"></div>
                </div>
              </div>
              <input
                type="hidden"
                :class="'apartment_id' + room.id"
                name="apartment_id[]"
              />

              <div
                class="col-md-2 d-flex flex-grow-1 align-items-center justify-content-end"
              >
                <select
                  class="form-control border-0 shadow-none form-control-lg selectpicker"
                  name="apartment_quantity[]"
                  title="0"
                  data-style="btn-lg py-2 h-52"
                  @change="getApartment($event, room)"
                >
                  <option value="0">0</option>
                  <option
                    :key="a"
                    :data-price="a * room.converted_price"
                    :data-id="room.id"
                    v-for="a in parseInt(room.no_of_rooms)"
                    :value="a"
                    >{{ a }} X {{ a * room.converted_price }}</option
                  >
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="d-grid gap-2">
          <div
            class="card-footer bg-transparent d-flex justify-content-between p-0 align-items-center"
          >
            <p class="text-heading mb-0">{{ apartments }} Apartments</p>
            <span class="fs-32 font-weight-bold text-heading"
              >{{ apartment.currency }}{{ total }}</span
            >
          </div>
          <button class="btn  btn-primary btn-block" type="submit">
            Book Now {{ total }} {{ form.room_quantity }}
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Persons from "../persons/Persons.vue";
export default {
  props: {
    rooms: Array,
    apartment: Object,
  },
  data() {
    return {
      roomsAvailable: [],
      total: 0,
      apartments: 0,
      totalRooms: 0,
      form: {
        room_quantity: [],
        selectedRooms: [],
      },
    };
  },
  created() {
    this.roomsAvailable = this.rooms;
  },
  components: {
    Persons,
  },
  methods: {
    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },

    getApartment(e, room) {
      this.totalRooms = 0;
      let selectRoomsQty = document.querySelectorAll(
        '[name="apartment_quantity[]"]'
      );
      let allSelectedRooms = [];
      let total = [];
      let apartment = (document.querySelector(".apartment_id" + room.id).value =
        room.id);

      selectRoomsQty.forEach((e, i) => {
        if (e.value != "") {
          allSelectedRooms.push(e.value);
          total.push(e.selectedOptions[0].dataset.price || 0);
        }
      });

      this.apartments = this.sum(allSelectedRooms);
      this.total = this.sum(total);

      if (this.form.selectedRooms.findIndex((x) => x.id == room.id) == -1) {
        this.form.selectedRooms.push(room);
      } else {
        this.form.selectedRooms.forEach((o, i) => {
          if (o.id == room.id) {
            this.form.selectedRooms.splice(i, 1);
          }
        });
      }
    },
  },
};
</script>
