<template>
  <div class="dropdown">
    <button
      class="btn btn-secondary dropdown-btn btn-block  pb-2 pt-2"
      type="button"
      id=""
      aria-haspopup="true"
      aria-expanded="false"
      @click="dropDownToggle()"
    >
      <i class="fal fa-users"></i> {{ adults + children }} Guests -
      {{ rooms }} Rooms
    </button>
    <div
      :class="{ 'd-none': showDropDown }"
      class="position-absolute  p-dropdown-toggle z-index-1"
      aria-labelledby=""
    >
      <div type="button" class="menu-dropdown p-3">
        <div class="counter pb-2 pt-2 border-bottom d-flex">
          <div class="text-left">
            <div class="" id="">Adults</div>
            <div class="text-muted " id="">Ages 13 or above</div>
          </div>
          <div
            id=""
            class="d-flex flex-grow-1 align-items-center justify-content-end"
          >
            <button
              type="button"
              :disabled="adults == 0"
              @click="addSubtract('adults', 's')"
              aria-label="decrease value"
              aria-describedby=""
              class="mr-5"
            >
              <span class=""><i class="fas fa-minus"></i></span>
            </button>
            <div class="mr-5">
              <span aria-hidden="true">{{ adults }}</span>
            </div>
            <button class="" @click="addSubtract('adults', 'a')" type="button">
              <span class="">
                <i class="far fa-plus"></i>
              </span>
            </button>
          </div>
        </div>
        <div class="counter pt-2 pb-2 d-flex">
          <div class="text-left">
            <div class="" id="">Children</div>
            <div class="text-muted" id="">Ages 0 to 12</div>
          </div>
          <div
            id=""
            class="d-flex flex-grow-1 align-items-center justify-content-end"
          >
            <button
              type="button"
              :disabled="children == 0"
              aria-label="decrease value"
              aria-describedby=""
              class="mr-5"
              @click="addSubtract('children', 's')"
            >
              <span class=""><i class="fas fa-minus"></i></span>
            </button>
            <div class="mr-5">
              <span>{{ children }}</span>
            </div>
            <button
              class=""
              @click="addSubtract('children', 'a')"
              type="button"
            >
              <span class="">
                <i class="far fa-plus"></i>
              </span>
            </button>
          </div>
        </div>

        <div class="counter pt-2 pb-2 d-flex">
          <div class="text-left">
            <div class="" id="">Rooms</div>
            <div class="text-muted" id=""></div>
          </div>
          <div
            id=""
            class="d-flex flex-grow-1 align-items-center justify-content-end"
          >
            <button
              type="button"
              :disabled="rooms == 1"
              aria-label="decrease value"
              aria-describedby=""
              class="mr-5"
              @click="addSubtract($event, 'rooms', 's')"
            >
              <span class=""><i class="fas fa-minus"></i></span>
            </button>
            <div class="mr-5">
              <span>{{ rooms }}</span>
            </div>
            <button class="" @click="addSubtract('rooms', 'a')" type="button">
              <span class="">
                <i class="far fa-plus"></i>
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" :value="rooms" name="rooms" />
    <input type="hidden" :value="children" name="no_of_children" />
    <input type="hidden" :value="adults" name="no_of_adults" />
  </div>
</template>
<script>
export default {
  data() {
    return {
      adults: 0,
      children: 0,
      totalPersons: 0,
      showDropDown: true,
      rooms: 1,
    };
  },

  methods: {
    addSubtract(e, type, as) {
      as === "a" ? this[type]++ : this[type]--;
      e.stopPropagation();
    },
    dropDownToggle() {
      this.showDropDown = !this.showDropDown;
    },
  },
};

// window.onclick = function(event) {
//   if (!event.target.matches(".dropdown-btn")) {
//     var dropdowns = document.getElementsByClassName("p-dropdown-toggle");
//     var i;
//     for (i = 0; i < dropdowns.length; i++) {
//       var openDropdown = dropdowns[i];
//       if (!openDropdown.classList.contains("d-none")) {
//         openDropdown.classList.add("d-none");
//       }
//     }
//   }
// };
</script>
