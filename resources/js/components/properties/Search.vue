<template>
    <div class="container container light-background pb-4 pt-1 primary-border rounded shadow">
        <h4 class="primary-color">BOOK YOUR STAY</h4>

        <div class="form-row">

            <div class="orm-group   form-border cursor-pointer search col-lg-3 col-md-5 bmd-form-group  mb-sm-2 mb-md-0">
                <label class=" pl-2 ml-4" for="flatpickr-input-f">Check-in</label>
                <date-range :check_in_date="1" placeholder="Check-in" @dateSelected="checkIn" />
            </div>


            <div
                class="orm-group  ml-lg-1   form-border cursor-pointer search col-lg-3 col-md-5 bmd-form-group  mb-sm-2 mb-md-0">
                <label class=" pl-2 ml-4" for="flatpickr-input-f">Check-out</label>
                <date-range :check_in_date="0" placeholder="Check-out" @dateSelected="checkOut" />
            </div>

            <div id="people-number" class="col-lg-4 col-md-4 cursor-pointer  px-sm-0 px-md-1 mb-sm-2 mb-md-0">
                <guests />
            </div>

            <div class="col-lg-1  col-md-3 col-12 check-availablility  ">
                <button type=" button" @click.prevent="search()"
                    class="btn btn-primary w-auto  btn-block m-auto  w-xs-100 rounded  bold check-availablility-button">
                    Check availablity
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

import Pickr from "vue-flatpickr-component";
import Guests from "./Guests.vue";
import DateRange from "./Date.vue";

export default {
    props: ["reload"],
    data() {
        return {
            guests: 0,
            form: {
                room_quantity: [],
                selectedRooms: [],
                children: 1,
                adults: 1,
                rooms: 1,
                check_in_checkout: null,
                checkin: null,
                checkout: null

            },
        };
    },
    components: {
        Pickr,
        Guests,
        DateRange,
    },
    computed: {
        ...mapGetters({
            locationSearch: "locationSearch",
        }),
    },
    mounted() {
        //this.build();
        console.log(this.checkForDate().checkin)
        this.form.checkin = typeof this.checkForDate().checkin !== 'undefined' ? this.checkForDate().checkin : 'Check-in'
        this.form.checkout = typeof this.checkForDate().checkout !== 'undefined' ? this.checkForDate().checkout : 'Check-out'
        // localStorage.clear()
    },
    methods: {
        ...mapActions({
            getProperties: "getProperties",
        }),
        dateSelected(value) {
            //this.form.check_in_checkout = value;
        },
        checkIn(value) {
            this.form.checkin = value;
        },
        checkOut(value) {
            this.form.checkout = value;
        },
        build(obj) {

            window.history.pushState("", "Title", "/apartments");

            let url = window.history.pushState(
                {},
                "",
                "?" + this.objectToQueryString(obj)
            );

            //this.$store.commit("setLocationSearch", locationSearch);
        },
        checkForDate(e) {
            const retrievedJsonString = localStorage.getItem('searchParams');
            // Check if the retrieved JSON string is not null
            if (retrievedJsonString !== null) {
                // Convert the JSON string back to an object
                const retrievedObject = JSON.parse(retrievedJsonString);

                return retrievedObject
            } else {
                return null
            }
        },
        objectToQueryString(obj) {
            return Object.keys(obj)
                .filter(key => obj[key] !== null && obj[key] !== undefined && obj[key] !== '') // Filter out null, undefined, and empty values
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(obj[key])}`)
                .join('&');
        },
        isCheckinGreaterThanCheckout(checkinDate, checkoutDate) {
            checkinDate = new Date(checkinDate);
            checkoutDate = new Date(checkoutDate);

            return checkinDate > checkoutDate;
        },
        search: function () {

            this.form.check_in_checkout = this.form.checkin + ' to ' + this.form.checkout;
            this.form.children = document.querySelector("#children").value;
            this.form.adults = document.querySelector("#adults").value;
            this.form.rooms = document.querySelector("#rooms").value;



            if (
                !this.form.checkout && !this.form.checkin
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (this.isCheckinGreaterThanCheckout(this.form.checkin, this.form.checkout)) {
                alert("Set your check-in and check-out correctly")
                return;
            }

            // Sample object to be saved
            const myObject = {
                rooms: this.form.rooms,
                check_in_checkout: this.form.check_in_checkout,
                checkin: this.form.checkin,
                checkout: this.form.checkout,
                children: this.form.children,
                adults: this.form.adults,
            };

            // Convert the object to a JSON string
            const jsonString = JSON.stringify(myObject);

            // Save the JSON string in localStorage with a specific key
            const storageKey = 'searchParams';
            localStorage.setItem(storageKey, jsonString);

            // Retrieve the object from localStorage
            const retrievedJsonString = localStorage.getItem(storageKey);

            // Convert the JSON string back to an object
            const retrievedObject = JSON.parse(retrievedJsonString);

            // Now 'retrievedObject' contains the object retrieved from localStorage

            this.build(myObject);

            //  console.log(this.build())
            window.location.reload()

        },
    },
};
</script>
  