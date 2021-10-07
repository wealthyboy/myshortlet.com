<template>
  <div class="row">
    <div v-if="paymentIsComplete" class="d-flex col-md-12 aligh">
      <!--Content-->
      <section class="">
        <div class="container">
          <div class="row">
            <div class="col-md-8 offset-md-2">
              <div class="error-page text-center">
                <h1>Thank you for shopping with us</h1>
                <p class="large">Your booking has been received .</p>
                <p class="large"></p>
                <a href="/" class="btn btn--primary space-t--2">Continue</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--End Content-->
    </div>
    <div v-if="!paymentIsComplete" class="col-md-7">
      <h3>Review and book</h3>
    </div>
    <div class="col-md-7">
      <form action="" method="get">
        <div class=" bg-white">
          <div class=" position-relative loaded-apartments">
            <div class="row no-gutters">
              <div class="col-md-3 position-relative">
                <div>
                  <a target="_blank" :href="property.link">
                    <img :src="property.image_m" class="img  img-fluid" />
                  </a>
                </div>
              </div>
              <div class="col-md-9 position-relative col-12 pl-3">
                <div class="d-flex  justify-content-between">
                  <div>
                    <a target="_blank" :href="property.link">{{
                      property.name
                    }}</a>
                    <div class="d">
                      <small
                        ><a :href="property.link" class="p-0">{{
                          property.city
                        }}</a
                        >, <a href="">{{ property.state }}</a></small
                      >
                    </div>
                    <div class="mb-5">
                      <div v-if="property.facilities.length" class="facilities">
                        <span
                          :key="facility.id"
                          v-for="facility in property.facilities"
                          >{{ facility.name }}.
                        </span>
                      </div>

                      <div
                        v-if="property.type == 'single'"
                        class="guests-section"
                      >
                        <span>{{ property.guests }} guests</span>
                        <span aria-hidden="true"> · </span>
                        <span>{{ property.rooms }} bedroom</span>
                        <span aria-hidden="true"> · </span>
                        <span>{{ property.baths }} baths</span>
                      </div>

                      <div v-if="property.is_refundable">Fully Refundable</div>
                      <div
                        v-if="property.free_services.length"
                        class="d-inline-flex"
                      >
                        <div
                          v-for="free_service in property.free_services"
                          :key="free_service.id"
                          class="refundable"
                        >
                          {{ free_service.name }} included
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end"
                >
                  <div class="reviews-section"></div>
                  <div class="text-right mr-2">
                    <div class="d-inline-flex"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class=" bg-white mt-1">
          <div class="card-body">
            <div v-if="!$root.loggedIn">
              <a
                data-toggle="modal"
                href="#"
                data-to="login"
                data-target="#loadModal"
                class=" auth-form"
                >Sign in</a
              >
              <span class="text-muted"
                >to book with your saved details. It helps to track your record!
              </span>
            </div>

            <div v-if="$root.loggedIn">
              You are signed in as {{ $root.user.email }}
            </div>
          </div>
        </div>
        <div class=" bg-white ">
          <h4 class="card-title p-3 border-bottom">Who's checking in?</h4>
          <div class="card-body">
            <div class="form-row">
              <div class="form-group bmd-form-group col-6">
                <label class="bmd-label-floating">First name</label>
                <input
                  id="first_name"
                  type="text"
                  class="form-control"
                  name="first_name"
                  v-model="form.first_name"
                  autofocus
                />
              </div>
              <div class="form-group bmd-form-group col-6">
                <label class="bmd-label-floating">Last name</label>
                <input
                  id="last_name"
                  type="text"
                  class="form-control"
                  name="last_name"
                  v-model="form.last_name"
                  autofocus
                />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group bmd-form-group col-2">
                <select
                  :v-model="form.code"
                  name="phone_none"
                  class="form-control"
                  id=""
                >
                  <option value=""> Select code</option>
                  <option value="+234" selected> +234</option>
                </select>
              </div>
              <div class="form-group bmd-form-group col-5">
                <label class="bmd-label-floating">Phone number</label>
                <input
                  type="text"
                  class="form-control"
                  name="phone_number"
                  v-model="form.phone_number"
                />
                <label
                  id="auth-phone-number-error"
                  class="error"
                  for=""
                ></label>
              </div>
              <div class="form-group bmd-form-group col-5">
                <label class="bmd-label-floating">Email address</label>
                <input
                  id="email"
                  type="email"
                  class="form-control"
                  name="email"
                  v-model="form.email"
                />
                {{ form.email }}
                <label id="auth-email-error" class="error" for=""></label>
              </div>
            </div>
          </div>
        </div>
        <div v-for="booking in bookings" :key="booking.id" class="bg-white">
          <h4 class="card-title p-3">Superior King Room</h4>
          <div class="card-body">
            <div>
              <i class="fas fa-info-circle mr-2"></i>Instant Confirmation
            </div>
            <div class="entire-apartment">
              <div>Entire apartment</div>
              <div class="d-flex justify-content-between flex-wrap">
                <div class="position-relative">
                  <span class="position-absolute svg-icon-section">
                    <svg>
                      <use xlink:href="#bedrooms-icon"></use>
                    </svg>
                  </span>
                  <span class="svg-icon-text"
                    >{{ booking.apartment.no_of_rooms }} Bedrooms</span
                  >
                </div>
                <div class="position-relative">
                  <span class="position-absolute svg-icon-section">
                    <svg>
                      <use xlink:href="#bathroom-icon"></use>
                    </svg>
                  </span>
                  <span class="svg-icon-text"
                    >{{ booking.apartment.toilets }} bathrooms</span
                  >
                </div>
                <div class="position-relative">
                  <span class="position-absolute svg-icon-section">
                    <svg>
                      <use xlink:href="#sleeps-icon"></use>
                    </svg>
                  </span>
                  <span class="svg-icon-text"
                    >{{ booking.apartment.guests }} Guests</span
                  >
                </div>
              </div>
            </div>

            <div class="position-relative">
              <span class="position-absolute svg-icon-section"></span>
              <span class="svg-icon-text">Air condition</span>
            </div>

            <div
              v-if="booking.apartment.free_services.length"
              class="d-inline-flex flex-wrap"
            >
              <div
                v-for="free_service in booking.free_services"
                :key="free_service.id"
                class="position-relative"
              >
                <span class="position-absolute svg-icon-section"></span>
                <span class="svg-icon-text"
                  >{{ free_service.name }} included</span
                >
              </div>
            </div>

            <template v-if="booking.apartment.bedrooms.length">
              <div
                v-for="bed in booking.apartment.bedrooms"
                :key="bed.id"
                class="position-relative"
              >
                <span class="position-absolute svg-icon-section"></span>
                <span class="svg-icon-text">{{ bed.parent.name }}</span>
                <span class="svg-icon-text">
                  {{ bed.pivot.bed_count }} {{ bed.name }}</span
                >
              </div>
            </template>

            <template v-if="booking.apartment.extra_services.length">
              <div class="card-title ">Extras</div>
              <p>We offer</p>

              <div
                v-for="extra_service in booking.apartment.extra_services"
                :key="extra_service.id"
                class="card-footer  mt-1  bg-transparent d-flex justify-content-between p-0 align-items-center"
              >
                <div class="checkbox">
                  <label id="box50" class="checkbox-label">
                    <input
                      for="box50"
                      name="extra_services[]"
                      :value="extra_service.id"
                      class="filter-attribute"
                      type="checkbox"
                      @change="addServices()"
                      :data-price="
                        extra_service.pivot.price *
                          parseInt(booking_details.days)
                      "
                    />
                    <span class="checkbox-custom rectangular"></span>
                    <span class="checkbox-label-text mt-1"
                      >{{ extra_service.name }}
                    </span>
                    <span style="margin-left: 8rem;" class="">
                      ( {{ booking_details.days }}
                      {{ booking_details.nights[1] }} )</span
                    >
                  </label>
                  <p>
                    {{ extra_service.description }}
                  </p>
                </div>
                <span
                  class="fs-32 mt-4 font-weight-bold text-heading total-price"
                >
                  {{ property.currency
                  }}{{ booking_details.days * extra_service.pivot.price }}</span
                >
              </div>
            </template>
          </div>
        </div>

        <template v-if="property.extra_services.length">
          <div class=" bg-white mt-2">
            <div class="p-2">You may be intrested in</div>
            <div
              v-for="extra_service in property.extra_services"
              :key="extra_service.id"
              class="card-body"
            >
              <div
                class="  bg-transparent d-flex justify-content-between p-0 align-items-center"
              >
                <div class="checkbox">
                  <label id="box50" class="checkbox-label">
                    <input
                      for="box50"
                      name="prices[]"
                      :value="extra_service.id"
                      class="filter-attribute"
                      type="checkbox"
                      @change="addServices()"
                      :data-price="extra_service.pivot.price"
                    />
                    <span class="checkbox-custom rectangular"></span>
                    <span class="checkbox-label-text mt-1">{{
                      extra_service.name
                    }}</span>
                  </label>
                </div>
                <span
                  class="fs-32 mt-4 font-weight-bold text-heading total-price"
                  >{{ property.currency }} {{ extra_service.pivot.price }}</span
                >
              </div>
            </div>
          </div>
        </template>

        <div class=" bg-white">
          <h4 class="card-title p-3 border-bottom">
            Important Trip Information
          </h4>
          <div class="card-body">
            <div>
              <h5>House Rules</h5>
              <ul class="list-unstyled">
                <li class="">
                  <p class="font-weight-500 text-heading mb-0">
                    Check-in -- {{ property.check_in_time }}
                  </p>
                </li>
                <li class="">
                  <p class="font-weight-500 text-heading mb-0">
                    Check-out -- {{ property.check_out_time }}
                  </p>
                </li>

                <li v-for="rule in property.rules" :key="rule.id" class="">
                  <p class="font-weight-500 text-heading mb-0">
                    {{ rule.name }}
                  </p>
                </li>
              </ul>
            </div>
            <div>
              <h5>Other Information</h5>
              <ul class="list-unstyled">
                <li class="">
                  <p class="font-weight-500 text-heading mb-0">
                    {{ property.cancellation_message }}
                  </p>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class=" bg-white ">
          <h4 class="card-title p-3 border-bottom">Payment</h4>
          <div class="card-body">
            <div>
              By clicking on the button below, I acknowledge that I have
              reviewed the Privacy Statement
            </div>
            <p class="form-group mt-3">
              <button
                type="buttom"
                @click.prevent="makePayment()"
                data-total=""
                class=" ml-1 btn btn-primary btn-round  btn-block  auth-form-button"
              >
                <div class="auth-spinner d-none">
                  spinner
                </div>
                <span class="lt">Make Payment</span>
              </button>
            </p>
            We use secure transmission and encrypted storage .
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-5">
      <div class="bg-white">
        <div class="card-title border-bottom p-3">Your Booking Details</div>
        <div>
          <ul class="list-unstyled mb-2 p-3">
            <li class="d-flex justify-content-between  mb-3 lh-22">
              <p class="text-gray-light mb-0">Check in</p>
              <p class="font-weight-500 text-heading mb-0">
                {{ booking_details.from }}
              </p>
            </li>
            <li class="d-flex justify-content-between mb-3 lh-22">
              <p class="text-gray-light mb-0">Check out</p>
              <p class="font-weight-500 text-heading mb-0">
                {{ booking_details.to }}
              </p>
            </li>
            <li class="d-flex justify-content-between lh-22">
              <p class="text-gray-light mb-0">Total length of stay</p>
              <p class="font-weight-500 text-heading mb-0">
                {{ booking_details.days }} {{ booking_details.nights[1] }}
              </p>
            </li>
          </ul>
        </div>
      </div>
      <div class="bg-white mt-2">
        <div class="card-title border-bottom p-3">Price Details</div>

        <div
          v-for="booking in bookings"
          :key="booking.id"
          class=" p-3  bg-transparent d-flex justify-content-between p-0 align-items-center"
        >
          <p class="text-heading mb-0">
            {{ booking.quantity }} X
            {{ booking.apartment.name || property.name }}
          </p>
          <span class="fs-32 font-weight-bold text-heading total-price">
            {{ property.currency }}{{ booking.total }}</span
          >
        </div>
        <div
          class="card-footer p-3  bg-transparent d-flex justify-content-between p-0 align-items-center"
        >
          <p class="text-heading mb-0">
            {{ booking_details.nights[0] }} {{ booking_details.nights[1] }}
          </p>
          <span class="fs-32 font-weight-bold text-heading total-price"
            >{{ property.currency }}{{ parseInt(booking_details.total) }}</span
          >
        </div>

        <div
          class="card-footer p-3  bg-transparent d-flex justify-content-between p-0 align-items-center"
        >
          <p class="text-heading mb-0">Total Price:</p>
          <span class="fs-32 font-weight-bold text-heading total-price"
            >{{ property.currency }}{{ amount }}</span
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  props: {
    property: Object,
    apartments: Array,
    booking_details: Object,
  },
  data() {
    return {
      scriptLoaded: null,
      paymentIsComplete: false,
      submiting: false,
      coupon_code: null,
      coupon: null,
      amount: this.booking_details.total,
      payment_method: null,
      paymentIsComplete: null,
      coupon_error: null,
      voucher: [],
      order_text: null,
      error: null,
      form: {
        first_name: null,
        last_name: null,
        email: null,
        code: null,
        phone_number: null,
        services: [],
        booking_ids: this.booking_details.booking_ids,
      },
    };
  },
  computed: {
    ...mapGetters({
      user: "user",
      userType: "userType",
      bookings: "bookings",
    }),
  },
  created() {
    this.scriptLoaded = new Promise((resolve) => {
      this.loadScript(() => {
        resolve();
      });
    });

    this.$store.commit("setBookings", this.apartments);
    this.$store.commit("setBookingTotal", this.booking_details.total);
  },
  components: {},
  methods: {
    ...mapActions({
      applyVoucher: "applyVoucher",
    }),
    addServices() {
      var inputs = document.querySelectorAll("input.filter-attribute:checked");
      this.form.services = [];

      var checkboxesChecked = [];
      for (var i = 0; i < inputs.length; i++) {}
      for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].checked) {
          checkboxesChecked.push(inputs[i].dataset.price);
          this.form.services.push(inputs[i].value);
        }
      }
      console.log(this.form.services);
      this.amount = this.sum(checkboxesChecked) + this.booking_details.total;
    },
    sum(arr) {
      return arr.reduce((a, b) => parseInt(a) + parseInt(b), 0);
    },

    loadScript(callback) {
      const script = document.createElement("script");
      script.src = "https://js.paystack.co/v1/inline.js";
      document.getElementsByTagName("head")[0].appendChild(script);
      if (script.readyState) {
        // IE
        script.onreadystatechange = () => {
          if (
            script.readyState === "loaded" ||
            script.readyState === "complete"
          ) {
            script.onreadystatechange = null;
            callback();
          }
        };
      } else {
        // Others
        script.onload = () => {
          callback();
        };
      }
    },
    applyCoupon: function() {
      if (!this.coupon) {
        this.coupon_error = "Enter a coupon code";
        setTimeout(() => {
          this.error = null;
        }, 2000);
        return;
      }
      this.coupon_code = this.coupon;
      this.coupon_error = null;
      this.submiting = true;
      axios
        .post("/book/coupon", {
          coupon: this.coupon,
          total: this.booking_details.total,
        })
        .then((response) => {
          this.submiting = false;
          this.coupon = "";
          this.voucher.push(response.data);
          this.amount = parseInt(response.data.sub_total);
        })
        .catch((error) => {
          this.submiting = false;
          this.coupon_error = error.response.data.error;
          if (error.response.status) {
            this.submiting = false;
          }
        });
    },
    makePayment: function() {
      this.amount = this.amount != 0 ? this.amount : this.booking_details.total;
      let context = this;
      this.payment_method = "card";
      var handler = PaystackPop.setup({
        key: "pk_test_c5b3db1649d534eec8ab6a35ed696ad624e3070a",
        email: context.form.email,
        amount: context.amount * 100,
        currency: "NGN",
        first_name: context.form.first_name,
        metadata: {
          custom_fields: [
            {
              guests: 33,
            },
          ],
        },
        callback: function(response) {
          this.paymentIsComplete = true;
          axios
            .post("/webhook/payment", {
              booking: context.form,
            })
            .then((response) => {
              this.submiting = false;
              console.log(response.data);
            })
            .catch((error) => {
              this.submiting = false;
            });
          if (response.status == "success") {
            context.paymentIsComplete = true;
          } else {
            this.error = "We could not complete your payment";
            context.order_text = "Make Payment";
          }
        },
        onClose: function() {
          context.order_text = "Make Payment";
          context.payment_is_processing = false;
        },
      });
      handler.openIframe();
    },
  },
};
</script>
