<template>
  <div v-if="apartments.length" class="rooms">
    <div class="mb-3">
      <div
        v-for="apartment in apartments"
        :key="apartment.id"
        class="row no-gutters"
      >
        <div class="col-md-3 col-6">
          <img
            :src="apartment.images[0].image_m"
            class="img-fluid"
            :alt="apartment.name"
          />
        </div>
        <div class="col-md-9 col-6">
          <div class="card-body">
            <h5 class="">
              {{ apartment.name || apartment.property.name }}
            </h5>
            <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
              {{ apartment.currency }}{{ apartment.converted_price }}
              <span class="fs-14 font-weight-500 text-gray-light"> /night</span>
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
      </div>

      <div class="row no-gutters">
        <div class="col-3">
          <div>Check-in</div>
        </div>
        <div class="col-8 ">
          <span class=""> {{ booking_details.from }} </span>
        </div>

        <div class="col-3">
          <div>Check-out</div>
        </div>
        <div class="col-8 ">
          <span class=""> {{ booking_details.to }} </span>
        </div>

        <hr />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["apartments", "booking_details"],
  data() {
    return {
      apartments_prop: [],
      form: {
        room_quantity: [],
        selectedRooms: [],
      },
    };
  },
  created() {},
  components: {},
  methods: {},
};
</script>
