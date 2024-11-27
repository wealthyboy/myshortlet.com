// bookingValidationMixin.js
export default {
    methods: {
        validateBooking() {
            const { start_date, end_date,  is_peak_period_active, days_limit, peak_period_days_Left } = this.peak_period;
    
            // Format dates to YYYY-MM-DD and create Date objects
            const peakStart = new Date(start_date.split("T")[0]);
            const peakEnd = new Date(end_date.split("T")[0]);
            const userStart = new Date(this.form.checkin);
            const userEnd = new Date(this.form.checkout);
    
            // Calculate the booking duration in days
            const bookingDays = Math.ceil((userEnd - userStart) / (1000 * 60 * 60 * 24));
    
            // Check if the user's start date falls within the peak period
            const userStartWithinPeakPeriod = userStart >= peakStart && userStart <= peakEnd;  
            // Enforce the minimum days limit if peak period is active and the start date is within the peak period
            if (is_peak_period_active  && userStartWithinPeakPeriod  && bookingDays < days_limit) {
              return false
            }

            return true
    
            // Proceed with booking if validations pass
        },
        isValidDate(dateString) {
            const dateObject = new Date(dateString);
            return !isNaN(dateObject) && dateString === dateObject.toISOString().split('T')[0];
        },
        isValidDateRange(dateRangeString) {
            // Split the date range string into two dates
            const [startDateString, endDateString] = dateRangeString.split(' to ');

            // Validate each date individually
            return this.isValidDate(startDateString) && this.isValidDate(endDateString);
        },

        dateSelected(value) {
            //this.form.check_in_checkout = value;
        },
    
        isValidDecemberBooking(startDate, endDate) {
            const start = new window.Date(startDate);
            const end = new window.Date(endDate);

            if (end < start) {
                return false; // Invalid date range
            }

            const startMonth = start.getMonth();
            const endMonth = end.getMonth();
            
            const decemberStart = new window.Date(start.getFullYear(), 11, 1); // December 1st
            const decemberEnd = new window.Date(start.getFullYear(), 11, 31); // December 31st
            
            if (end < decemberStart || start > decemberEnd) {
                return true; // No days in December, so no 10-day requirement
            }

            // Calculate the actual December start and end within the range
            const rangeStartInDecember = start < decemberStart ? decemberStart : start;
            const rangeEndInDecember = end > decemberEnd ? decemberEnd : end;

            // Calculate the number of days in December within the range
            const daysInDecember = Math.ceil((rangeEndInDecember - rangeStartInDecember) / (1000 * 60 * 60 * 24)) + 1;

            // Ensure at least 10 days in December if any part of the range is in December
            return daysInDecember >= 10;
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

        showAvailability: function () {
            this.form.check_in_checkout = this.form.checkin + ' to ' + this.form.checkout;
            this.form.persons = document.querySelector("#persons").value;
            this.form.rooms = document.querySelector("#rooms").value;
            var now = new window.Date().getTime(); // Current timestamp
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
                    this.apartmentIsChecked = true

                    this.roomsAv = response.data;
                    this.roomsIsAv = response.data;
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

            const { start_date, end_date, days_limit } = this.peak_period;

            if ( !this.validateBooking() ) {
                alert(`Bookings from ${start_date.split("T")[0]} to ${end_date.split("T")[0]} require a minimum stay of ${days_limit} days.`);                
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
        isValidDate(dateString) {
            // Attempt to create a Date object from the dateString
            const dateObject = new Date(dateString);

            // Check if the dateObject is a valid Date and the dateString remains the same after conversion
            return !isNaN(dateObject) && dateString === dateObject.toISOString().split('T')[0];
        },

        search: function () {

            this.form.check_in_checkout = this.form.checkin + ' to ' + this.form.checkout;
            this.form.persons = document.querySelector("#persons").value;
            this.form.rooms = document.querySelector("#rooms").value;

            
            if ( !this.form.checkin && !this.form.checkout ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if ( !this.isValidDate(this.form.checkin) ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if ( !this.isValidDate(this.form.checkout) ) {
                alert("Please select your check-in and check-out dates")
                return;
            }

            if ( this.isCheckinGreaterThanCheckout(this.form.checkin, this.form.checkout) ) {
                alert("Set your check-in and check-out dates correctly")
                return;
            } 

            if ( this.form.checkin === this.form.checkout ) {
                alert("Set your check-in and check-out dates correctly. They cannot be the same")
                return;
            }

            const { start_date, end_date, days_limit } = this.peak_period;

            if ( !this.validateBooking() ) {
                alert(`Bookings from ${start_date.split("T")[0]} to ${end_date.split("T")[0]} require a minimum stay of ${days_limit} days.`);                
                return;
            }

            this.apartmentIsChecked = true



            var now = new Date().getTime();
            this.btnText = 'Checking...'
            this.isDisabled = true;
            const myObject = {
                rooms: this.form.rooms,
                check_in_checkout: this.form.check_in_checkout,
                checkin: this.form.checkin,
                checkout: this.form.checkout,
                children: this.form.children,
                persons: this.form.persons,
                expiry: now + 3600000
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

            this.build(myObject);

            //  console.log(this.build())
            window.location.reload()

        },
        checkApartmentAvailabity: function (apartment) {

            console.log(this.form.checkin + ' to ' + this.form.checkout)

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

            const { start_date, end_date, days_limit } = this.peak_period;

            if ( !this.validateBooking() ) {
                alert(`Bookings from ${start_date.split("T")[0]} to ${end_date.split("T")[0]} require a minimum stay of ${days_limit} days.`);                
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

            this.apartment_id = ap.id

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

            this.apartment_id = ap.id 
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

        checkAvailabity: function () {
            this.form.check_in_checkout = this.form.checkin + ' to ' + this.form.checkout;
            this.form.persons = document.querySelector("#persons").value;
            this.form.rooms = document.querySelector("#rooms").value;
            this.apartmentIsChecked = true
            var now = new window.Date().getTime(); // Current timestamp
            // Sample object to be savedyy
            const myObject = {
                rooms: this.form.rooms,
                check_in_checkout: this.form.check_in_checkout,
                checkin: this.form.checkin,
                checkout: this.form.checkout,
                persons: this.form.persons,
                expiry: now + 3600000
            };

            // Example usage:
            const startDate = '2024-12-05';
            const endDate = '2024-12-15';
            const retrievedJsonString = localStorage.getItem('searchParams');
            const queryParams = new URLSearchParams(myObject).toString();
            const newUrl = `${window.location.origin}${window.location.pathname}?${queryParams}`;

            // Update the URL without reloading the page
            window.history.pushState({ path: newUrl }, '', newUrl);
            const storageKey = 'searchParams';
            const jsonString = JSON.stringify(myObject);
            const currentValue = localStorage.getItem(storageKey);

            // Check if the item exists in localStorage
            if (currentValue !== null) {
                localStorage.setItem(storageKey, jsonString);
            } else {
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

            if (this.form.checkin === this.form.checkout) {
                alert("Set your check-in and check-out dates correctly. They cannot be the same")
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
    }
  };
  