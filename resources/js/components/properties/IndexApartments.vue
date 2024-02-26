<template>
    <div class="">
        <form id="multiple-form" :action="'/book/' + property.slug" method="GET" class="form-group">
            <input type="hidden" name="_token" :value="$root.token" />
            <input type="hidden" name="property_id" :value="property.id" />
            <div v-if="filter">
                <h3 class="bold-2">Choose your apartment</h3>
                <div class="form-row">
                    <div class="form-group   form-border cursor-pointer search col-md-5 bmd-form-group  mb-sm-2 mb-md-0">
                        <label class="pl-2 " for="flatpickr-input-f">Check-in - Check-out</label>
                        <date :isDateNeedsToToOpen="isDateNeedsToToOpen" @dateSelected="dateSelected" />
                    </div>
                    <div id="people-number" class="col-md-5 cursor-pointer px-sm-0 px-md-1">
                        <guests />
                    </div>
                    <div class="col-md-2 check-availablility  mt-sm-2 mt-md-0">
                        <button type="button" @click.prevent="checkAvailabity()"
                            class="btn btn-primary btn-block m-auto bold-2 check-availablility-button rounded">
                            Check availablity
                        </button>
                    </div>
                </div>
            </div>


            <div id="full-" v-if="propertyLoading" class="full-bg position-relative">
                <div class="signup--middle">
                    <div class="loading">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>

            <div v-if="!gallery">
                <div id="" v-if="!propertyLoading && !roomsAv.length" class="name mt-1 rounded bg-white p-2">
                    <div class="text-muted text-danger">
                        {{
                            error_msg || "There are not available apartments for your search."
                        }}

                    </div>
                </div>
            </div>




            <div :class="{ 'header-filter': propertyIsLoading }" id="" class="name mt-1 rounded p-2">
                <div class="position-relative">
                    <input type="hidden" name="property_id" value="217" />
                    <template v-if="roomsAv.length">
                        <div class="row">
                            <apartment :showReserve="filter" :classType="classType" @showRoom="showRoom" @reserve="reserve"
                                :amenities="amenities" v-for="room in roomsAv" :key="room.id" :room="room" :stays="stays"
                                :qty="qty" />
                        </div>
                    </template>
                </div>
            </div>
        </form>


        <transition name="modal-fade">
            <div v-if="showModal" @click.self="closeModal" class="modal-overlay d-flex">
                <div class="modal d-block">
                    <div class="modal-content-header d-flex align-items-center p-3 justify-content-between">
                        <h5 class="modal-title" id="">Apartment Information</h5>
                        <a @click.prevent="closeModal" href="#" role="button">
                            <svg class="uitk-icon" aria-label="Close, go back to hotel details." role="img"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
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
                                <div class="room-carousel owl-carousel owl-theme">
                                    <div v-if="room.google_drive_video_link" class="item">
                                        <iframe style="width: 100%;" height="400" :src="room.google_drive_video_link">
                                        </iframe>
                                    </div>
                                    <template v-if="room.google_drive_image_links">
                                        <div class="item" :key="index"
                                            v-for="(image, index) in room.google_drive_image_links">
                                            <img :src="image" class="img  img-fluid rounded" />
                                        </div>
                                    </template>
                                    <div class="item" :key="image.id" v-for="image in room.images">
                                        <img :src="image.image" class="img  img-fluid rounded" />
                                    </div>
                                </div>
                                <div class="container p-0">
                                    <h4 class="primary-color">Check availablity FOR {{ room.name }}</h4>

                                    <form id="single-form" :action="'/book/' + property.slug" method="GET"
                                        class="form-group">
                                        <input type="hidden" name="_token" :value="$root.token" />
                                        <input type="hidden" name="property_id" :value="property.id" />
                                        <div>
                                            <div class="row  quick-view p-3">
                                                <div
                                                    class="form-group  p-0  form-border cursor-pointer search col-md-5 bmd-form-group  mb-sm-2 mb-md-0">
                                                    <label class=" label" for="flatpickr-input-f">Check-in -
                                                        Check-out</label>
                                                    <date :isDateNeedsToToOpen="isDateNeedsToToOpen"
                                                        @dateSelected="dateSelected" />
                                                </div>
                                                <div id="people-number"
                                                    class=" guest col-md-5 cursor-pointer px-sm-0 px-md-1">
                                                    <guests />
                                                </div>
                                                <div class="col-md-2 check-availablility  mt-sm-2 mt-md-0">
                                                    <button :class="{ disabled: loading }" type="button"
                                                        @click.prevent="checkSingleAvailabity(room)"
                                                        class="btn btn-primary btn-block m-auto bold-2 check-availablility-button rounded">
                                                        <span v-if="loading" class="spinner-border spinner-border-sm"
                                                            role="status" aria-hidden="true"></span> Check

                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" mt-3">
                                            <button v-if="apartmentIsChecked && apartmentIsAvailable" type="button"
                                                @click.prevent="reserveSingle(room)"
                                                class="btn btn-primary  m-auto bold-2  rounded">
                                                Reserve
                                            </button>

                                            <div v-if="!apartmentIsAvailable && apartmentIsChecked" class="text-danger">
                                                This apartment is not available on your selected date
                                            </div>
                                        </div>
                                    </form>
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
                                        <span class="">
                                            Air conditioning
                                        </span>
                                        <span class="ml-2">
                                            Connecting rooms available
                                        </span>

                                        <span class="ml-2">
                                            Flat-screen TV
                                        </span>
                                        <span class="ml-2">
                                            Pillowtop bed
                                        </span>
                                        <span class="ml-2">
                                            Premium bedding
                                        </span>
                                        <span class="ml-2">
                                            Blackout drapes/curtains
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
                                        <span class="svg-icon-text">{{ room.guests }} Guests</span>
                                    </div>
                                </div>

                                <div class="uitk-spacing uitk-spacing-margin-blockend-six">
                                    <h3 class="uitk-heading uitk-heading-5 uitk-spacing uitk-spacing-margin-blockend-six">
                                        Apartment
                                        amenities</h3>
                                    <div class="row" style="">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <svg class="" aria-hidden="true" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path fill-rule="evenodd"
                                                        d="M20 13V4.83C20 3.27 18.73 2 17.17 2c-.75 0-1.47.3-2 .83l-1.25 1.25c-.16-.05-.33-.08-.51-.08-.4 0-.77.12-1.08.32l2.76 2.76c.2-.31.32-.68.32-1.08 0-.18-.03-.34-.07-.51l1.25-1.25a.828.828 0 0 1 1.41.59V13H2v6c0 1.1.9 2 2 2 0 .55.45 1 1 1h14c.55 0 1-.45 1-1 1.1 0 2-.9 2-2v-6h-2ZM4 19h16v-4H4v4Z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <h4 class="ml-2">Bathroom</h4>
                                            </div>
                                            <div class="">
                                                <div class="">
                                                    <ul class="" role="list">
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Bathrobes</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Eco-friendly
                                                                toiletries</span>
                                                        </li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Free toiletries</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Hair
                                                                dryer</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Private
                                                                bathroom</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Shower</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=" "></span><span class="">Slippers</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Toothbrush and toothpaste not
                                                                available</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Towels</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center"><svg class="" aria-hidden="true"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path fill-rule="evenodd"
                                                        d="M11 7h8a4 4 0 0 1 4 4v9h-2v-3H3v3H1V5h2v9h8V7zm-1 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <h4 class="ml-2">Bedroom</h4>
                                            </div>
                                            <div class="">
                                                <div class="">
                                                    <ul class="" role="list">
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Bed sheets</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Blackout
                                                                drapes/curtains</span>
                                                        </li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span
                                                                class="uitk-typelist-item-child">Climate-controlled air
                                                                conditioning</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Free cribs/infant
                                                                beds</span>
                                                        </li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Pillowtop bed</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Premium bedding</span></li>
                                                        <li class="" role="listitem">
                                                            <span aria-hidden="true" class=""></span><span
                                                                class="">Rollaway/extra beds not available</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center"><svg
                                                    class="uitk-icon uitk-layout-flex-item" aria-hidden="true"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z">
                                                    </path>
                                                </svg>
                                                <h4 class="ml-2">Entertainment</h4>
                                            </div>
                                            <div class="">
                                                <div class="">
                                                    <ul class="" role="list">
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Large flat-screen
                                                                TV</span>
                                                        </li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="uitk-typelist-item-child">
                                                                Cable channels</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="uitk-typelist-item-child"> iPod
                                                                dock</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="uitk-typelist-item-child"> Pay
                                                                movies</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center"><svg
                                                    class="uitk-icon uitk-layout-flex-item" aria-hidden="true"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path fill-rule="evenodd"
                                                        d="M20.15 10.15c-1.59 1.59-3.74 2.09-5.27 1.38L13.41 13l6.88 6.88-1.41 1.41L12 14.41l-6.89 6.87-1.41-1.41 9.76-9.76c-.71-1.53-.21-3.68 1.38-5.27 1.92-1.91 4.66-2.27 6.12-.81 1.47 1.47 1.1 4.21-.81 6.12zm-9.22.36L8.1 13.34 3.91 9.16a4 4 0 0 1 0-5.66l7.02 7.01z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <h4 class="ml-2">Food and drink
                                                </h4>
                                            </div>
                                            <div class="">
                                                <div class="">
                                                    <ul class="" role="list">
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">24-hour room service</span>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center"><svg
                                                    class="uitk-icon uitk-layout-flex-item" aria-hidden="true"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path fill-rule="evenodd"
                                                        d="m1 9 2 2a12.73 12.73 0 0 1 18 0l2-2A15.57 15.57 0 0 0 1 9zm8 8 3 3 3-3a4.24 4.24 0 0 0-6 0zm-2-2-2-2a9.91 9.91 0 0 1 14 0l-2 2a7.07 7.07 0 0 0-10 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <h4 class="ml-2">Internet</h4>
                                            </div>
                                            <div class="">
                                                <div class="u">
                                                    <ul class="o" role="list">
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">WiFi</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center"><svg
                                                    class="uitk-icon uitk-layout-flex-item" aria-hidden="true"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z">
                                                    </path>
                                                </svg>
                                                <h4 class="ml-2">More</h4>
                                            </div>
                                            <div class="">
                                                <div class="">
                                                    <ul class="" role="list">
                                                        <li class="" role="listitem">
                                                            <span aria-hidden="true" class="">
                                                            </span>
                                                            <span class="">Connecting rooms
                                                                available</span>
                                                        </li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Daily housekeeping</span>
                                                        </li>

                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="d">Iron/ironing board</span>
                                                        </li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">LED light bulbs</span></li>
                                                        <li class="" role="listitem">
                                                            <span aria-hidden="true" class=""></span><span
                                                                class="">Phone</span>
                                                        </li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Recycling bin</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Safe</span></li>
                                                        <li class="" role="listitem"><span aria-hidden="true"
                                                                class=""></span><span class="">Wardrobe or closet</span>
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
import Apartment from "./Apartment.vue";
import Date from "./Date.vue";
import Pickr from "vue-flatpickr-component";
import axios from "axios";

export default {
    props: {
        apartments: Array,
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
            propertyLoading: false,
            propertyIsLoading: false,
            isDateNeedsToToOpen: false,
            error_msg: null,
            showModal: false,
            apartmentIsAvailable: false,
            apartmentIsChecked: false,
            loading: false,
            classType: ['col-12 col-md-4'],
            room: {},
            form: {
                room_quantity: [],
                selectedRooms: [],
                children: 1,
                adults: 1,
                rooms: 1,
                check_in_checkout: null,
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

        const retrievedJsonString = localStorage.getItem('searchParams');
        // Check if the retrieved JSON string is not null
        if (retrievedJsonString !== null) {
            const retrievedObject = JSON.parse(retrievedJsonString);
            this.form.check_in_checkout = retrievedObject.check_in_checkout
            //this.checkAvailabity()
        }

        jQuery(function () {


            $(".owl-carousel").owlCarousel({
                margin: 0,
                dots: true,
                nav: true,
                navText: [
                    '<div class="nav-btn prev-slide"><svg  viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg"><path d="M19.9 40L1.3 20 19.9 0" stroke="#000" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
                    '<div class="nav-btn next-slide"><svg  viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg"><path d="M.1 0l18.6 20L.1 40" stroke="#000" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
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


        if (!this.filter) {
            //  this.type = 'col-md-3'
            this.classType = ['col-12 col-md-3']
            this.roomsAv = this.apartments;
        } else {
            this.classType = ['col-12 col-md-4']
            this.getApartments()
        }
    },
    components: {
        Pickr,
        Guests,
        Apartment,
        Date,
    },

    methods: {
        showRoom(room) {
            console.log(room)
            this.showModal = !this.showModal;
            this.room = room
            jQuery(function () {
                $(".room-carousel").owlCarousel({
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

        },
        openModal() {
            this.showModal = true;
            document.body.style.overflow = 'hidden'; // Prevent scrolling on the body
            // Add event listener to close modal when clicking outside
            document.body.addEventListener('click', this.clickOutsideHandler);
        },
        closeModal() {
            this.showModal = false;
            // Remove event listener when closing modal
            document.body.style.overflow = ''; // Prevent scrolling on the body

            document.body.removeEventListener('click', this.clickOutsideHandler);
        },
        clickOutsideHandler(event) {
            // Check if the click target is outside of the modal
            if (!this.$refs.modal.contains(event.target)) {
                this.closeModal();
            }

            document.body.style.overflow = ''; // Prevent scrolling on the body

        },
        dateSelected(value) {
            this.form.check_in_checkout = value;
        },
        getApartments() {
            this.propertyLoading = true
            //const now = new Date().getTime()

            // Calculate the total number of seconds since the beginning of the day
            // const seconds = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();

            // console.log(window.location, now)
            axios
                .get(window.location + '?t=' + Math.random())
                .then((response) => {
                    this.roomsAv = response.data.data;
                    this.stays = response.data.nights;
                    this.propertyLoading = false;

                    //document.getElementById("full-bg").remove();
                    jQuery(function () {
                        $(".owl-carousel").owlCarousel({
                            margin: 0,
                            dots: true,
                            nav: true,
                            navText: [
                                '<div class="nav-btn prev-slide"><svg  viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg"><path d="M19.9 40L1.3 20 19.9 0" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
                                '<div class="nav-btn next-slide"><svg  viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg"><path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
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
                    // commit("setPropertyLoading", false);
                    // commit("setProperties", []);
                    console.log(error)
                });
        },
        checkAvailabity: function () {
            // this.build()

            this.form.children = document.querySelector("#children").value;
            this.form.adults = document.querySelector("#adults").value;
            this.form.rooms = document.querySelector("#rooms").value;
            if (
                !this.form.check_in_checkout ||
                this.form.check_in_checkout.split(" ").length < 2
            ) {
                this.isDateNeedsToToOpen = true;
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

            this.form.children = document.querySelector("#children").value;
            this.form.adults = document.querySelector("#adults").value;
            this.form.rooms = document.querySelector("#rooms").value;
            if (
                !this.form.check_in_checkout ||
                this.form.check_in_checkout.split(" ").length < 2
            ) {
                this.isDateNeedsToToOpen = true;
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
                    this.apartmentIsChecked = true
                    this.loading = false
                    this.apartmentIsAvailable = response.data
                    return Promise.resolve();
                })
                .catch((error) => {
                    this.loading = false
                });

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
            this.propertyIsLoading = true;

            let ap = room.room
            if (
                !this.form.check_in_checkout ||
                this.form.check_in_checkout.split(" ").length < 2
            ) {
                this.isDateNeedsToToOpen = true;
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
            this.propertyIsLoading = true;

            let ap = room
            if (
                !this.form.check_in_checkout ||
                this.form.check_in_checkout.split(" ").length < 2
            ) {
                this.isDateNeedsToToOpen = true;
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
</script>
  