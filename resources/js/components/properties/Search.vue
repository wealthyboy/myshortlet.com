<template>
    <div class="container container light-background pb-4 pt-1 primary-border rounded shadow">
        <h4 class="primary-color">BOOK YOUR STAY</h4>

        <div class="form-row">

            <div class="orm-group   form-border cursor-pointer search col-lg-5 col-md-5 bmd-form-group  mb-sm-2 mb-md-0">
                <label class=" pl-2 ml-4" for="flatpickr-input-f">Check-in - Check-out</label>
                <date-range @dateSelected="dateSelected" />
            </div>

            <div id="people-number" class="col-lg-5 col-md-4 cursor-pointer px-sm-0 px-md-1">
                <guests />
            </div>

            <div class="col-lg-2 col-md-3 col-12 check-availablility  mt-xs-2 mt-md-0">
                <button type=" button" @click.prevent="search()"
                    class="btn btn-primary btn-block m-auto rounded  bold check-availablility-button">
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
    },
    methods: {
        ...mapActions({
            getProperties: "getProperties",
        }),
        dateSelected(value) {
            this.form.check_in_checkout = value;
        },
        build() {
            let locationSearch = [];
            document.querySelectorAll(".location-search").forEach((e, i) => {
                locationSearch.push(e.name + "=" + e.value);
            });

            window.history.pushState("", "Title", "/apartments");

            let url = window.history.pushState(
                {},
                "",
                "?" + locationSearch.join("&")
            );

            this.$store.commit("setLocationSearch", locationSearch);
        },
        search: function () {

            this.form.children = document.querySelector("#children").value;
            this.form.adults = document.querySelector("#adults").value;
            this.form.rooms = document.querySelector("#rooms").value;

            if (
                !this.form.check_in_checkout ||
                this.form.check_in_checkout.split(" ").length < 2
            ) {
                alert("Please select your check-in and check-out dates")
                // this.isDateNeedsToToOpen = true;
                return;
            }

            // Sample object to be saved
            const myObject = {
                rooms: this.form.rooms,
                check_in_checkout: this.form.check_in_checkout,
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
            console.log(retrievedObject);


            this.build();
            window.location.reload()

        },
    },
};
</script>
  