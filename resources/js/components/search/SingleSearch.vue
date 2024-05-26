<template>
    <div class="">
        <form id="multiple-form" :action="'/book/' + property.slug" method="GET" class="form-group">
            <input type="hidden" name="_token" :value="$root.token" />
            <input type="hidden" name="property_id" :value="property.id" />
            <div v-if="filter">
                <h3 class="bold-2">Check availablity {{ apartment.name }}</h3>
                <div class="form-row">
                    <div class="form-group   form-border cursor-pointer search col-md-3 bmd-form-group  mb-sm-2 mb-md-0">
                        <label class="pl-2 " for="flatpickr-input-f">Check-in</label>
                        <date :check_in_date="1" placeholder="Check-in" :isDateNeedsToToOpen="isDateNeedsToToOpen"
                            @dateSelected="checkIn" />
                    </div>
                    <div
                        class="form-group  ml-lg-1  form-border cursor-pointer search col-md-3 bmd-form-group  mb-sm-2 mb-md-0">
                        <label class="pl-2 " for="flatpickr-input-f">Check-out</label>
                        <date :check_in_date="0" placeholder="Check-out" :isDateNeedsToToOpen="isDateNeedsToToOpen"
                            @dateSelected="checkOut" />
                    </div>
                    <div id="people-number" class="col-md-4 cursor-pointer px-sm-0 px-md-1 mb-sm-2 mb-md-0">
                        <guests />
                    </div>
                    <div class="col-md-1 w-100 check-availablility  ">
                        <button type="button" @click.prevent="checkAvailabity()"
                            class="btn btn-primary btn-block  w-auto w-xs-100 m-auto bold-2 check-availablility-button rounded">
                            Check availablity
                        </button>
                    </div>
                </div>
            </div>


            <div :class="{ 'header-filter': propertyIsLoading }" id="" class="name mt-1 rounded p-2">
                <div class="position-relative">
                    <input type="hidden" name="property_id" value="217" />

                    <div class="row">
                        <apartment :showReserve="apartmentIsChecked" :classType="classType" @showImages="showImages"
                            @showRoom="showRoom" @reserve="reserve" :amenities="amenities" :room="apartment" :stays="stays"
                            :qty="qty" />
                    </div>

                </div>
            </div>
        </form>
    </div>
</template>
<script>
import Guests from "../properties/Guests.vue";
import Apartment from "../properties/Apartment.vue";

import Date from "../properties/Date.vue";
import Pickr from "vue-flatpickr-component";
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
import axios from "axios";

export default {
    props: {
        apartment: Object,
        property: Object,
        propertys_not_available: Array,
        nights: Array,
        amenities: Array,
        isAgent: Boolean,
        filter: {
            type: Number,
            default: 1
        },
        showReserve: Number,
        gallery: Number
    },
    data() {
        return {
            settings: {
                arrows: true,
                fade: true,
                swipe: true,
                touchMove: true
            },
            roomsAv: [],
            total: 0,
            aps: 0,
            apTotal: 0,
            attrPrice: 0,
            guests: 0,
            amount: 0,
            apQ: [],
            qty: false,
            stays: null,
            loading: false,
            highlights: [],
            propertyLoading: false,
            propertyIsLoading: false,
            isDateNeedsToToOpen: false,
            singleApartmentIsChecked: false,
            singleApartmentIsAvailable: false,
            apartment_facilities: null,
            error_msg: null,
            showModal: false,
            apartmentIsAvailable: false,
            apartmentIsChecked: false,
            loading: false,
            classType: ['col-lg-3 col-md-4 col-12'],
            message: "LKNL",
            title: "LM;;",
            showImageModal: false,
            room: {},
            form: {
                room_quantity: [],
                selectedRooms: [],
                children: 1,
                adults: 1,
                rooms: 1,
                check_in_checkout: null,
                checkin: null,
                checkout: null,
                property_id: this.property.id,
            },
        };
    },
    created() {
        // this.stays = this.nights;
        //this.roomsAv = this.apartments;
    },
    mounted() {
        // Get all elements with class 'p-loader'

        let lo = document.getElementById("full-bg")

        if (lo) {
            document.getElementById("full-bg").remove();
        }


        jQuery(function () {


            $('.sm-flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });

        })

        const retrievedJsonString = localStorage.getItem('searchParams');
        // Check if the retrieved JSON string is not null
        if (retrievedJsonString !== null) {
            const retrievedObject = JSON.parse(retrievedJsonString);
            this.form.checkin = retrievedObject.checkin
            this.form.checkout = retrievedObject.checkout

            //this.checkAvailabity()
        }

        jQuery(function () {

            $(".owl-carousel").owlCarousel({
                margin: 0,
                dots: true,
                nav: true,
                loop: true,
                navText: [
                    '<div class="nav-btn prev-slide d-flex justify-content-center align-items-center mr-1"><svg  viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg"><path d="M19.9 40L1.3 20 19.9 0"  fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
                    '<div class="nav-btn next-slide d-flex justify-content-center align-items-center ml-1"><svg  viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg"><path d="M.1 0l18.6 20L.1 40"  fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
                ],

                responsive: {
                    0: {
                        items: 1,
                    },
                    850: {
                        items: 1,
                    },
                    1000: {
                        items: 1,
                    },
                },
            });
        });

        const parentElement = document.getElementById('sm-main-banner');

        if (parentElement) {
            // Get all child elements with the class d-none
            const hiddenDivs = parentElement.querySelectorAll('.d-none');

            // Remove each hidden div
            hiddenDivs.forEach(div => {
                div.classList.remove('d-none');
            });
        }



        if (!this.filter) {
            //  this.type = 'col-md-3'
            this.classType = ['col-12 col-lg-3 col-md-6']
            this.roomsAv = this.apartments;
        } else {
            this.classType = ['col-12 col-lg-4 col-md-6']
            this.getApartments()
        }
    },
    components: {
        Pickr,
        Guests,
        Date,
        VueSlickCarousel,
        Apartment
    },

    methods: {
        isValidDate(dateString) {
            // Attempt to create a Date object from the dateString
            const dateObject = new Date(dateString);

            // Check if the dateObject is a valid Date and the dateString remains the same after conversion
            return !isNaN(dateObject) && dateString === dateObject.toISOString().split('T')[0];
        },
        checkIn(value) {
            this.form.checkin = value;
        },
        checkOut(value) {
            this.form.checkout = value;
        },

        parseStringToArray(str) {
            const array = str.split(",");
            // Filter out non-numeric values and empty strings
            return array;
        },


        dateSelected(value) {
            this.form.check_in_checkout = value;
        },
        parseDateRange(dateRangeString) {
            // Split the date range string into two dates
            const [startDateString, endDateString] = dateRangeString.split(' to ');

            // Parse the start date and end date
            const startDate = new Date(startDateString);
            const endDate = new Date(endDateString);

            // Return an object containing both start and end dates
            return { startDate, endDate };
        },
        getQueryParam(key) {
            // Get the current query string
            const queryString = window.location.search;

            // Parse the query string into URLSearchParams
            const urlParams = new URLSearchParams(queryString);

            // Get the value of the specified key
            const value = urlParams.get(key);

            // Return both the key and value
            return { key, value };
        },
        groupData(room) {
            this.apartment_facilities = room.apartment_facilities.reduce((acc, obj) => {
                const parentName = obj.parent.name;
                if (!acc[parentName]) {
                    acc[parentName] = [];
                }
                acc[parentName].push(obj);
                return acc;
            }, {});

            console.log(room.apartment_facilities)
        },
        isValidDateRange(dateRangeString) {
            // Split the date range string into two dates
            const [startDateString, endDateString] = dateRangeString.split(' to ');

            // Validate each date individually
            return this.isValidDate(startDateString) && this.isValidDate(endDateString);
        },
        isValidDate(dateString) {
            // Regular expression pattern for "YYYY-MM-DD" format
            const pattern = /^\d{4}-\d{2}-\d{2}$/;

            // Check if the string matches the pattern
            if (!pattern.test(dateString)) {
                return false; // Return false if the format doesn't match
            }

            // Attempt to create a Date object from the dateString
            const dateObject = new window.Date(dateString);

            // Check if the Date object represents a valid date
            return !isNaN(dateObject) && dateString === dateObject.toISOString().split('T')[0];
        },
        getApartments() {
            this.propertyLoading = true

            const urlParams = new URLSearchParams(window.location.search);
            const queryString = urlParams.toString();


            axios
                .get(window.location + '?t=' + Math.random())
                .then((response) => {
                    this.roomsAv = response.data.data;
                    this.stays = response.data.nights;
                    this.propertyLoading = false;
                    const paramNameToGet = 'check_in_checkout';
                    const { key, value } = this.getQueryParam(paramNameToGet);


                    if (value && this.isValidDateRange(value)) {
                        this.apartmentIsChecked = true
                    }

                    if (this.form.checkin && this.form.checkout) {
                        if (this.isValidDate(this.form.checkin) && this.isValidDate(this.form.checkout)) {
                            this.apartmentIsChecked = true
                        }
                    }

                    //document.getElementById("full-bg").remove();
                    jQuery(function () {
                        $(".owl-carousel").owlCarousel({
                            margin: 0,
                            dots: true,
                            nav: true,
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
                    return Promise.resolve();
                })
                .catch((error) => {
                    console.log(error)
                });
        },
        objectToQueryString(obj) {
            return Object.keys(obj)
                .filter(key => obj[key] !== null && obj[key] !== undefined && obj[key] !== '') // Filter out null, undefined, and empty values
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(obj[key])}`)
                .join('&');
        },
        isCheckinGreaterThanCheckout(checkinDate, checkoutDate) {
            checkinDate = new window.Date(checkinDate);
            checkoutDate = new window.Date(checkoutDate);
            return checkinDate > checkoutDate;
        },
        checkAvailabity: function () {
            this.form.check_in_checkout = this.form.checkin + ' to ' + this.form.checkout;
            this.form.persons = document.querySelector("#persons").value;
            this.form.rooms = document.querySelector("#rooms").value;
            this.apartmentIsChecked = true
            var now = new window.Date().getTime(); // Current timestamp
            // Sample object to be saved
            const myObject = {
                rooms: this.form.rooms,
                check_in_checkout: this.form.check_in_checkout,
                checkin: this.form.checkin,
                checkout: this.form.checkout,
                persons: this.form.persons,
                expiry: now + 3600000

            };

            const storageKey = 'searchParams';
            const jsonString = JSON.stringify(myObject);
            const currentValue = localStorage.getItem(storageKey);


            // Check if the item exists in localStorage
            if (currentValue !== null) {
                // Update the retrieved value

                // Store the updated value back into jsonString
                localStorage.setItem(storageKey, jsonString);

                // Optionally, return true to indicate successful update
            } else {
                // Item with the specified name does not exist in localStorage
                // Handle this case as needed, such as returning false or throwing an error
                localStorage.setItem(storageKey, jsonString);

            }
            // Convert the object to a JSON strin


            if (
                !this.form.check_in_checkout ||
                this.form.check_in_checkout.split(" ").length < 2
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (
                !this.isValidDate(this.form.checkin)
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (
                !this.isValidDate(this.form.checkout)
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (this.isCheckinGreaterThanCheckout(this.form.checkin, this.form.checkout)) {
                alert("Set your check-in and check-out dates correctly")
                return;
            }

            // Now 'retrievedObject' contains the object retrieved from localStorage
            this.propertyIsLoading = true

            axios
                .get('/apartments', {
                    params: {
                        rooms: this.form.rooms,
                        check_in_checkout: this.form.check_in_checkout,
                        children: this.form.children,
                        adults: this.form.adults,
                    }
                })
                .then((response) => {

                    this.roomsAv = response.data.data;
                    this.stays = response.data.nights;
                    this.propertyIsLoading = false;

                    jQuery(function () {
                        $(".owl-carousel").owlCarousel({
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
                    return Promise.resolve();
                })
                .catch((error) => {
                    this.propertyIsLoading = false
                    // commit("setPropertyLoading", false);
                    // commit("setProperties", []);
                });

            // this.getProperties(window.location);
        },

        checkSingleAvailabity: function (apartment) {

            this.form.check_in_checkout = this.form.checkin + ' to ' + this.form.checkout;
            this.form.persons = document.querySelector("#persons").value;
            this.form.rooms = document.querySelector("#rooms").value;

            var now = new window.Date().getTime(); // Current timestamp
            // Sample object to be saved
            const myObject = {
                rooms: this.form.rooms,
                check_in_checkout: this.form.check_in_checkout,
                checkin: this.form.checkin,
                checkout: this.form.checkout,
                persons: this.form.persons,
                expiry: now + 3600000

            };

            const storageKey = 'searchParams';

            const jsonString = JSON.stringify(myObject);

            const currentValue = localStorage.getItem(storageKey);


            // Check if the item exists in localStorage
            if (currentValue !== null) {
                // Update the retrieved value

                // Store the updated value back into jsonString
                localStorage.setItem(storageKey, jsonString);

                // Optionally, return true to indicate successful update
            } else {
                // Item with the specified name does not exist in localStorage
                // Handle this case as needed, such as returning false or throwing an error
                localStorage.setItem(storageKey, jsonString);

            }


            if (
                !this.form.check_in_checkout ||
                this.form.check_in_checkout.split(" ").length < 2
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (
                !this.isValidDate(this.form.checkin)
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (
                !this.isValidDate(this.form.checkout)
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (this.isCheckinGreaterThanCheckout(this.form.checkin, this.form.checkout)) {
                alert("Set your check-in and check-out dates correctly")
                return;
            }


            this.loading = true

            axios
                .get('/apartments', {
                    params: {
                        rooms: this.form.rooms,
                        check_in_checkout: this.form.check_in_checkout,
                        children: this.form.children,
                        adults: this.form.adults,
                        apartment_id: apartment.id
                    }
                })
                .then((response) => {
                    console.log(response.data)
                    this.singleApartmentIsChecked = true
                    this.loading = false
                    this.singleApartmentIsAvailable = response.data
                    return Promise.resolve();
                })
                .catch((error) => {
                    this.loading = false
                });

        },
        checkIn(value) {
            this.form.checkin = value;
        },
        checkOut(value) {
            this.form.checkout = value;
        },

        check(e) {
            let extra_services = document.querySelectorAll(
                '[name="extra_services[]"]'
            );
            let attr = [];
            extra_services.forEach((e, i) => {
                if (e.checked) {
                    attr.push(e.dataset.price);
                }
            });

            this.attrPrice = this.sum(attr);
        },
        sum(arr) {
            return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
        },
        getApartmentQuantity({ total, aps }) {
            console.log(total, aps)
            this.total = total;
            this.aps = aps;
            this.apTotal = total;
            this.amount = this.apTotal;
        },
        reserve(room) {

            let ap = room.room
            if (
                !this.form.checkout && !this.form.checkin
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (
                !this.isValidDate(this.form.checkin)
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (
                !this.isValidDate(this.form.checkout)
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (this.isCheckinGreaterThanCheckout(this.form.checkin, this.form.checkout)) {
                alert("Set your check-in and check-out dates correctly")
                return;
            }


            let selectApartmentQty = document.querySelectorAll(".room-q");
            var checked = [];
            let filters = {};

            filters = {
                [this.property.id]: ap.id,
            };

            checked.push(filters);

            this.form.check_in_checkout = this.form.checkin + ' to ' + this.form.checkout;

            let form = {
                apartment_quantity: checked,
                propertyId: this.property.id,
                apID: ap.id,
                check_in_checkout: this.form.check_in_checkout,
            };

            this.propertyIsLoading = true;



            axios
                .post("/book/store", form)
                .then((response) => {
                    this.propertyLoading = false;
                    if (response.data) {
                        document.querySelector("#multiple-form").submit();
                    } else {
                        this.error_msg =
                            "It seems we could not further your request .Try a diffrent date.";
                        this.roomsAv = [];
                    }
                })
                .catch((error) => {
                    this.error_msg =
                        "It seems we could not further your request .Try a diffrent date.";
                });
        },

        reserveSingle(room) {

            let ap = room
            if (
                !this.form.check_in_checkout ||
                this.form.check_in_checkout.split(" ").length < 2
            ) {
                return;
            }

            if (
                !this.isValidDate(this.form.checkin)
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (
                !this.isValidDate(this.form.checkout)
            ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if (this.isCheckinGreaterThanCheckout(this.form.checkin, this.form.checkout)) {
                alert("Set your check-in and check-out dates correctly")
                return;
            }


            let selectApartmentQty = document.querySelectorAll(".room-q");
            var checked = [];
            let filters = {};

            filters = {
                [this.property.id]: ap.id,
            };

            checked.push(filters);

            let form = {
                apartment_quantity: checked,
                propertyId: this.property.id,
                apID: ap.id,
                check_in_checkout: this.form.check_in_checkout,
            };

            this.propertyIsLoading = true;



            axios
                .post("/book/store", form)
                .then((response) => {
                    this.propertyLoading = false;
                    if (response.data) {
                        document.querySelector("#single-form").submit();
                    } else {
                        this.error_msg =
                            "It seems we could not further your request .Try a diffrent date.";
                        this.roomsAv = [];
                    }
                })
                .catch((error) => {
                    this.error_msg =
                        "It seems we could not further your request .Try a diffrent date.";
                });
        },
    },
};

class IntersectionObserverHandler {
    constructor(options) {
        this.observer = new IntersectionObserver(this.handleIntersection.bind(this), options);
        this.dynamicClassesMap = new Map();
    }

    handleIntersection(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const dynamicClasses = this.dynamicClassesMap.get(entry.target);
                if (dynamicClasses) {
                    entry.target.classList.remove('opacity-0');
                    dynamicClasses.forEach(className => entry.target.classList.add(className));
                    observer.unobserve(entry.target);
                }
            }
        });
    }

    observe(targets) {
        targets.forEach(target => {
            const { element, dynamicClasses } = target;

            // Check if the element exists in the DOM before observing
            if (element && document.body.contains(element)) {
                this.observer.observe(element);
                this.dynamicClassesMap.set(element, dynamicClasses);
            }
        });
    }

    unobserve(targets) {
        targets.forEach(target => {
            this.observer.unobserve(target.element);
            this.dynamicClassesMap.delete(target.element);
        });
    }
}
</script>

<style scoped>
/* Adjust modal styles for full width and height */
.fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

.min-h-screen {
    min-height: 100vh;
}

.bg-opacity-75 {
    background-color: rgba(0, 0, 0, 0.75);
}
</style>
  