<template>
  <div>
    <div class="people-number  d-flex  form-border  ">
      <div class="align-self-center ml-3">
        <i class="fas fa-user-friends  text-black"></i>
      </div>
      <div class="ml-2">
        <label class="bmd-label-static  pl-1">Rooms and Guests</label>
        <div class="people-dropdown-info ml-1 pb-1 ">
          <span class="adults">{{ persons }}</span> Person(s),
          <span class="rooms">{{ rooms }}</span> rooms
        </div>
      </div>
    </div>
    <div style="min-width: 100%; z-index: 2; background: #ffffff; opacity: 0;" id="people-dropdown"
      class="people-dropdown d-none pl-4 pt-3 pb-4 pr-4 position-absolute  guest-dropdown border">
      <div class=" d-flex p-2 justify-content-between">
        <div class="text-left">
          <div class="" id="">Person(s)</div>
          <div class="text-muted " id=""></div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <button type="button" @click="decrement('persons')" aria-label="decrease value" aria-describedby=""
            class="mr-3 raised cursor-pointer add-subtract  min-adults" data-name="adults" data-math="minus">
            <span class=""><i class="fas fa-minus"></i></span>
          </button>
          <div class="">
            <span aria-hidden="true" class="adults">{{ persons }}</span>
          </div>
          <button data-math="add" @click="increment('persons')" data-name="adults" data-number="1"
            class="ml-3 raised cursor-pointer add-subtract" type="button">
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
          <button type="button" @click="decrement('rooms')" aria-label="decrease value" aria-describedby=""
            data-math="minus" data-name="rooms" class="mr-3 raised min-rooms cursor-pointer ">
            <span class=""><i class="fas fa-minus"></i></span>
          </button>
          <div class="">
            <span class="rooms" aria-hidden="true">{{ rooms }}</span>
          </div>

          <button data-math="add" data-number="0" @click="increment('rooms')" data-name="rooms"
            class="ml-3 raised cursor-pointer " type="button">
            <span class="">
              <i class="far fa-plus"></i>
            </span>
          </button>
        </div>

      </div>
      <div class=" d-flex  p-2 justify-content-between">
        <a href="#" class="close-dropdown btn px-3 py-1 btn-primary rounded" role="button" type="button">Close</a>
      </div>


      <input type="hidden" class="location-search" name="rooms" :value="rooms" id="rooms" />
      <input type="hidden" class="location-search" name="children" :value="children" id="children" />
      <input type="hidden" class="location-search" name="persons" :value="persons" id="persons" />
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      guests: 0,
      rooms: 2,
      children: null || 0,
      persons: 1,
      sParams: null,
    };
  },
  mounted() {
    this.romms = this.checkForGuests() ? this.checkForGuests().rooms : 2
    // this.children = this.checkForGuests() ? this.checkForGuests().children : 1
    this.persons = this.checkForGuests() ? this.checkForGuests().persons : 1
  },
  methods: {

    increment(name) {

      if (name === 'rooms') {
        if (this.rooms < 3) {
          this.rooms++
        }
      }

      if (name === 'persons') {
        if (this.persons < 7) {
          this.persons++
        }
      }

      this.storeData()



    },
    decrement(name) {
      if (name === 'rooms') {
        if (this.rooms > 2) {
          this.rooms--
        }
      }
      if (name === 'persons') {
        if (this.persons > 1) {
          this.persons--
        }
      }

      this.storeData()

      console.log(localStorage.getItem('sParams'))
    },
    storeData() {
      var now = new Date().getTime(); // Current timestamp
      var data = {
        persons: this.persons,
        rooms: this.rooms,
        expiry: now + 3600000
      };
      localStorage.setItem('sParams', JSON.stringify(data));
    },
    retrieveData() {
      var storedData = localStorage.getItem('sParams');
      if (storedData) {
        storedData = JSON.parse(storedData);
        // Check if data is expired
        if (new Date().getTime() < storedData.expiry) {
          this.storedData = storedData.value;
        } else {
          // Remove expired data from storage
          localStorage.removeItem('sParams');
          this.storedData = null;
        }
      } else {
        this.storedData = null;
      }
    },

    checkForGuests(e) {
      const retrievedJsonString = localStorage.getItem('searchParams');
      // Check if the retrieved JSON string is not null
      if (retrievedJsonString !== null) {
        // Convert the JSON string back to an object
        const retrievedObject = JSON.parse(retrievedJsonString);

        if (new Date().getTime() < retrievedObject.expiry) {
          return retrievedObject;
        } else {
          // Remove expired data from storage
          localStorage.removeItem('searchParams');
          return null
        }

        return retrievedObject
      } else {
        return null
      }
    }
  }
};
</script>
