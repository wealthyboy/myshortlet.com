<template>
    <div class="">
        <form id="multiple-form" :action="'/book/' + property.slug" method="GET" class="form-group">
            <input type="hidden" name="_token" :value="$root.token" />
            <input type="hidden" name="property_id" :value="property.id" />
            <input type="hidden" name="apartment_id" :value="apartment_id" />

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
                        <button type="button" @click.prevent="handleAvailabity()"
                            class="btn btn-primary btn-block  w-auto w-xs-100 m-auto bold-2 check-availablility-button rounded">
                            Check availablity
                        </button>
                    </div>
                </div>
            </div>


            <div v-if="roomsIsAv" class="mt-3">
                <div class="alert alert-success">
                    This apartment is available 
                </div>
                <button 
                    @click.prevent="reserveFromTop()"
                    type="button" 
                    class="btn btn-primary  m-auto bold-2  rounded">
                    Click here to book
                </button>
            </div>


            <div >
              
                <div id="" v-if="!propertyIsLoading && apartmentIsChecked && !roomsIsAv"  class="name mt-1 rounded bg-white p-2">
                    <div class="text-muted text-danger">
                        {{
                             "This apartment is not available for your selected date."
                        }}

                    </div>
                </div>
            </div> 

            <div id="" class="name mt-1 rounded p-2">
                <div class="position-relative">
                    <div    :class="{ 'header-filter': propertyIsLoading }"  class="row">
                        <apartment :showReserve="false" :classType="classType" @showImages="showImages"
                            @showRoom="showRoom" @reserve="reserve" :amenities="amenities" :room="roomsAv" :stays="stays"
                            :qty="qty" />
                    </div>

                </div>
            </div>
        </form>

        <transition name="modal-fade">
            <div v-if="showModal" @click.self="closeModal" class="modal-overlay d-flex">
                <div class="modal d-block">
                    <div class="modal-content-header d-flex align-items-center p-3 mt-4 justify-content-between">
                        <h5 class="modal-title" id="">Apartment Information</h5>
                        <a @click.prevent="closeModal" href="#"
                            class="modal-close d-flex justify-content-center align-items-center" role="button">
                            <svg class="" aria-label="Close, go back to hotel details." role="img" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title id="undefined-close-toolbar-title">Close, go back to hotel details.</title>
                                <path
                                    d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z">
                                </path>
                            </svg>
                        </a>
                    </div>
                    <div v-if="!gallery" class="modal-body quick-view">
                        <div class="row">
                            <div class="col-md-12 rounded">
                                <div class=" ">

                                    <VueSlickCarousel v-bind="settings" :arrows="true" :dots="true">

                                        <div 
                                            v-if="room.image" 
                                            class="item">

                                            <img
                                                :alt="room.name"

                                                :title="'book ' + room.name + '  Avenue Montaigne'"
                                                :src="room.image"
                                                class="img room-image img-fluid rounded"
                                                itemprop="contentUrl"
                                                />
                                        </div>
                                        <template v-if="room.images">

                                            <div class="item" :key="index"
                                                v-for="(image, index) in room.images">

                                                  
                                                <img :src="image.image" class="img room-image  img-fluid rounded" />

                                                 <div
                                                        class="image-caption position-absolute"
                                                        v-if="image.caption"
                                                        >
                                                        {{ image.caption}}
                                                    </div>
                                                
                                            </div>
                                              
                                        </template>

                                        <div v-if="room.google_drive_video_link" class="item">
                                            <iframe style="width: 100%;" class="custom-iframe"
                                                :src="room.google_drive_video_link">
                                            </iframe>
                                        </div>
                                    </VueSlickCarousel>
                                </div>
                                <div class="container p-0">
                                    <h4 class="primary-color">{{ room.name }}</h4>
                                </div>

                                    
                                <div class="card-title bold-2 text-size-1-big  mt-lg-0 mt-sm-3 ">
                                    {{ room.name }}
                                </div>
                                <div class="mb-5 bg-grey p-3 rounded">
                                    <div class="d-flex">
                                        <svg class="" aria-describedby="cleanliness-description" role="img"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <desc id="cleanliness-description">cleanliness</desc>
                                            <path
                                                d="M19.14 7.25 18 10l-1.14-2.86L14 6l2.86-1.14L18 2l1.14 2.86L22 6l-2.86 1.25zM11 10 9 4l-2 6-6 2 6 2 2 6 2-6 6-2-6-2zm4.5 10.5-1.5-1 1.5-1 1-1.5 1 1.5 1.5 1-1.5 1-1 1.5-1-1.5z">
                                            </path>
                                        </svg>
                                        <h3 class="">Highlights</h3>
                                    </div> 
                                    <div class="">

                                        <span v-for="(h, index ) in highlights" :key="index" class="ml-2">
                                            {{ h }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex  flex-column">
                                    <div class="position-relative mb-2">
                                        <span class="position-absolute svg-icon-section">
                                            <svg>
                                                <use xlink:href="#bedrooms-icon"></use>
                                            </svg>
                                        </span>
                                        <span class="svg-icon-text">{{ room.no_of_rooms }} Bedrooms</span>
                                    </div>
                                    <div class="position-relative mb-2">
                                        <span class="position-absolute svg-icon-section">
                                            <svg>
                                                <use xlink:href="#bathroom-icon"></use>
                                            </svg>
                                        </span>
                                        <span class="svg-icon-text">{{ room.toilets }} bathrooms</span>
                                    </div>
                                    <div class="position-relative mb-2">
                                        <span class="position-absolute svg-icon-section">
                                            <svg>
                                                <use xlink:href="#sleeps-icon"></use>
                                            </svg>
                                        </span>
                                        <span class="svg-icon-text">{{ room.max_adults }} Guests</span>
                                    </div>

                                    <div class="position-relative mb-1">
                                        <span class="position-absolute svg-icon-section">
                                            <svg>
                                                <use xlink:href="#location_city"></use>
                                            </svg>
                                        </span>
                                        <span class="svg-icon-text">{{ room.floor }} </span>
                                    </div>
                                </div>

                                <div class="uitk-spacing uitk-spacing-margin-blockend-six">
                                    <h3 class="uitk-heading uitk-heading-5 uitk-spacing uitk-spacing-margin-blockend-six">
                                        Apartment
                                        amenities</h3>
                                    <div class="row" id="apartment-fac" style="">
                                        <div v-for="(objects, parentName) in apartment_facilities" :key="parentName"
                                            class="col-md-6 margin-bottom-13rem">
                                            <div class="d-flex align-items-center">
                                                <svg class="uitk-icon uitk-layout-flex-item" aria-hidden="true"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z">
                                                    </path>
                                                </svg>

                                                <h4 class="ml-2">{{ parentName }}</h4>
                                            </div>
                                            <div class="">
                                                <div class="">
                                                    <ul class="" role="list">
                                                        <li class="" v-for="obj in objects" :key="obj.id" role="listitem">
                                                            <span aria-hidden="true" class=""></span><span class=""> {{
                                                                obj.name }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </transition>
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
import booking from "../../mixins/booking";


export default {
    mixins: [booking],
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
        gallery: Number,
        peak_period: {
            type: Object,
            default: {}
        },
    },
    data() {
        return {
            settings: {
                arrows: true,
                fade: true,
                swipe: true,
                touchMove: true
            },
            roomsAv: {},
            roomsIsAv: null,
            apartmentIsAvailable: [],
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
            apartment_id: null,
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
        if (retrievedJsonString !== null) {
            const retrievedObject = JSON.parse(retrievedJsonString);
            this.form.checkin = retrievedObject.checkin
            this.form.checkout = retrievedObject.checkout
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
            const hiddenDivs = parentElement.querySelectorAll('.d-none');
            hiddenDivs.forEach(div => {
                div.classList.remove('d-none');
            });
        }

        this.roomsAv =  this.apartment

        if (!this.filter) {
            this.classType = ['col-12 col-lg-3 col-md-6']
            this.roomsAv = this.apartments;
        } else {
            this.classType = ['col-12 col-lg-4 col-md-6']
           // this.getApartments()
        }
        if (retrievedJsonString !== null) {
          this.showAvailability()
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
      
        checkIn(value) {
            this.form.checkin = value;
        },
        checkOut(value) {
            this.form.checkout = value;
        },

        parseStringToArray(str) {
            const array = str.split(",");
            return array;
        },
        showImages(room) {
            this.showImageModal = !this.showImageModal;
            this.room = room
        },
        showRoom(room) {
            this.showModal = !this.showModal;
            this.room = room
            this.groupData(room)
            this.highlights = this.parseStringToArray(room.teaser);

            jQuery(function () {
                $(".custom-iframe").on("touchstart", function (event) {
                    var startX = event.touches[0].clientX;
                    $(this).on("touchmove", function (event) {
                        var moveX = event.touches[0].clientX - startX;
                        if (Math.abs(moveX) > 50) { // Adjust threshold as needed
                            if (moveX > 0) {
                                $(".owl-carousel").trigger("prev.owl.carousel");
                            } else {
                                $(".owl-carousel").trigger("next.owl.carousel");
                            }
                            $(this).off("touchmove");
                        }
                    });

                    $(this).on("touchend", function () {
                        $(this).off("touchmove");
                    });
                });

                $(".owl-carousel").owlCarousel({
                    margin: 0,
                    nav: true,
                    dots: true,
                    navText: [
                        '<div class="nav-btn prev-slide d-flex z-index justify-content-center align-items-center mr-1"><svg  viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg"><path d="M19.9 40L1.3 20 19.9 0"  fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
                        '<div class="nav-btn next-slide d-flex z-index justify-content-center align-items-center ml-1"><svg  viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg"><path d="M.1 0l18.6 20L.1 40"  fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
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

        },
        openModal() {
            this.showModal = true;
            document.body.style.overflow = 'hidden';
            document.body.addEventListener('click', this.clickOutsideHandler);
        },
        closeModal() {
            this.showModal = false;
            document.body.style.overflow = ''; 
            document.body.removeEventListener('click', this.clickOutsideHandler);
        },
        openImageModal() {
            this.showImageModal = true;
            document.body.style.overflow = 'hidden'; 
            document.body.addEventListener('click', this.clickOutsideHandler);
        },
        closeImageModal() {
            this.showImageModal = false;
            document.body.style.overflow = ''; 
            document.body.removeEventListener('click', this.clickOutsideHandler);
        },
        clickOutsideHandler(event) {
            if (!this.$refs.modal.contains(event.target)) {
                this.closeModal();
            }
            document.body.style.overflow = ''; // Prevent scrolling on the body
        },


        dateSelected(value) {
            this.form.check_in_checkout = value;
        },
        parseDateRange(dateRangeString) {
            const [startDateString, endDateString] = dateRangeString.split(' to ');
            const startDate = new Date(startDateString);
            const endDate = new Date(endDateString);
            return { startDate, endDate };
        },
        getQueryParam(key) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const value = urlParams.get(key);
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

        },
    
        handleAvailabity: function () {
            this.roomsIsAv = null
            this.showAvailability()
        },

        showAvailability: function () {
            this.form.check_in_checkout = this.form.checkin + ' to ' + this.form.checkout;
            this.form.persons = document.querySelector("#persons").value;
            this.form.rooms = document.querySelector("#rooms").value;
            var now = new window.Date().getTime(); 
            const myObject = {
                rooms: this.form.rooms,
                check_in_checkout: this.form.check_in_checkout,
                checkin: this.form.checkin,
                checkout: this.form.checkout,
                persons: this.form.persons,
                expiry: now + 3600000,
                apartment_id: this.apartment.id
            };

            const storageKey = 'searchParams';
            const jsonString = JSON.stringify(myObject);
            const currentValue = localStorage.getItem(storageKey);

            if (currentValue !== null) {
                localStorage.setItem(storageKey, jsonString);
            } else {
                localStorage.setItem(storageKey, jsonString);
            }


            if ( !this.form.check_in_checkout ||
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

            const { start_date, end_date, days_limit } = this.peak_period;

            if ( !this.validateBooking() ) {
                this.apartmentIsChecked = false
                alert(`Bookings from ${start_date.split("T")[0]} to ${end_date.split("T")[0]} require a minimum stay of ${days_limit} days.`);                
                return false;
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
                        apartment_id: this.apartment.id
                    }
                })
                .then((response) => {
                    this.roomsIsAv = response.data.apartments
                    this.apartmentIsChecked = true
                    if (null !== response.data.apartments) {
                        this.roomsAv = response.data.apartments
                    }
                    //this.stays = response.data.nights;
                    this.propertyIsLoading = false;
                })
                .catch((error) => {
                    this.propertyIsLoading = false
                    // commit("setPropertyLoading", false);
                    // commit("setProperties", []);
                });

            // this.getProperties(window.location);
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
                apartment_id: room.id
            };

            this.propertyIsLoading = true;
            this.apartment_id = room.room.id

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
        reserveFromTop(room) {
            let ap = this.apartment
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
                apartment_id: ap.id
            };

            this.propertyIsLoading = true;
            this.apartment_id = ap.id

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
  