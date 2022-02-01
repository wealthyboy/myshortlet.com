<template>
  <div>
    <div class="people-number  d-flex  form-border  ">
      <div class="align-self-center ml-2">
        <i class="fas fa-user-friends"></i>
      </div>
      <div class="ml-2">
        <label class="bmd-label-static  pl-1">Rooms and Guests</label>
        <div class="people-dropdown-info ml-1 pb-1">
          <span class="adults">{{ adults }}</span> adults
          <span class="children">{{ children }}</span> children -
          <span class="rooms">{{ rooms }}</span> rooms
        </div>
      </div>
    </div>
    <div
      style="min-width: 100%; z-index: 1; background: #ffffff; opacity: 0;"
      id="people-dropdown"
      class="people-dropdown d-none pl-4 pt-3 pb-4 pr-4 position-absolute  border"
    >
      <div class=" d-flex p-2 justify-content-between">
        <div class="text-left">
          <div class="" id="">Adults</div>
          <div class="text-muted " id="">Ages 13 or above</div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <button
            type="button"
            disabled=""
            aria-label="decrease value"
            aria-describedby=""
            class="mr-3   raised cursor-pointer add-subtract  min-adults"
            data-name="adults"
            data-math="minus"
          >
            <span class=""><i class="fas fa-minus"></i></span>
          </button>
          <div class="">
            <span aria-hidden="true" class="adults">{{ adults }}</span>
          </div>
          <button
            data-math="add"
            data-name="adults"
            data-number="1"
            class="ml-3 raised cursor-pointer add-subtract"
            type="button"
          >
            <span class="">
              <i class="far fa-plus"></i>
            </span>
          </button>
        </div>
      </div>

      <div class=" d-flex p-2  justify-content-between">
        <div class="text-left">
          <div class="" id="">Children</div>
          <div class="text-muted" id="">0 to 13</div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <button
            type="button"
            disabled=""
            aria-label="decrease value"
            aria-describedby=""
            class="mr-3 raised min-children cursor-pointer  add-subtract"
            data-name="children"
            data-math="minus"
          >
            <span><i class="fas fa-minus"></i></span>
          </button>
          <div class="">
            <span class="children" aria-hidden="true">{{ children }}</span>
          </div>

          <button
            data-math="add"
            data-number="1"
            data-name="children"
            class="ml-3 raised cursor-pointer add-subtract"
            type="button"
          >
            <span class="">
              <i class="far fa-plus"></i>
            </span>
          </button>
        </div>
      </div>

      <div class=" d-flex  p-2 justify-content-between">
        <div class="text-left">
          <div class="" id="">Rooms</div>
          <div class="text-muted " id=""></div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <button
            type="button"
            disabled=""
            aria-label="decrease value"
            aria-describedby=""
            data-math="minus"
            data-name="rooms"
            class="mr-3 raised min-rooms cursor-pointer add-subtract"
          >
            <span class=""><i class="fas fa-minus"></i></span>
          </button>
          <div class="">
            <span class="rooms" aria-hidden="true">{{ rooms }}</span>
          </div>

          <button
            data-math="add"
            data-number="0"
            data-name="rooms"
            class="ml-3 raised cursor-pointer add-subtract"
            type="button"
          >
            <span class="">
              <i class="far fa-plus"></i>
            </span>
          </button>
        </div>
      </div>

      <input
        type="hidden"
        class="location-search"
        name="rooms"
        :value="rooms"
        id="rooms"
      />
      <input
        type="hidden"
        class="location-search"
        name="children"
        :value="children"
        id="children"
      />
      <input
        type="hidden"
        class="location-search"
        name="adults"
        :value="adults"
        id="adults"
      />
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      guests: 0,
      rooms: this.$root.request.rooms || 1,
      children: this.$root.request.children || 0,
      adults: this.$root.request.adults || 1,
    };
  },
};
</script>
