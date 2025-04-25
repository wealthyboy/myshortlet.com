<template>
  <div class="row">
    <div v-if="paymentIsComplete" class="d-flex col-md-12 align-items-center" style="height:65vh; overflow:hidden;">
      <booking-complete />
    </div>
    <div v-if="!paymentIsComplete" class=" col-md-7 mb-3">
      <h3 class="bold-3">Review and book</h3>
    </div>
    <div v-if="!paymentIsComplete" class="col-lg-7 col-md-7 ">
      <form action="" method="get">
        <!-- <booking-property :property="property" /> -->

        <booking-login :booking_details="booking_details" />

        <div class=" bg-white mt-3">
          <h3 class="card-title p-3 custom-border-bottom bold-3">Who's checking in?</h3>
          <div class="card-body pt-0">
            <div class="form-row">
              <div class="form-group bmd-form-group col-6">
                <label class="bmd-label-floating">First name</label>
                <input id="first_name" type="text" class="form-control required" name="first_name"
                  v-model="form.first_name" @input="removeError($event)" @blur="vInput($event)"
                  :class="{ 'has-danger': errors.first_name }" />
                <span v-if="errors.first_name">
                  <strong class="text-danger text-size-2">{{
                    formatError(errors.first_name)
                  }}</strong>
                </span>
              </div>
              <div class="form-group bmd-form-group col-6">
                <label class="bmd-label-floating">Last name</label>
                <input id="last_name" type="text" class="form-control required" name="last_name" v-model="form.last_name"
                  @input="removeError($event)" @blur="vInput($event)" :class="{ 'has-danger': errors.last_name }" />
                <span v-if="errors.last_name">
                  <strong class="text-danger text-size-2">{{
                    formatError(errors.last_name)
                  }}</strong>
                </span>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group pt-4 col-3 ">
                <select name="phone_code"  v-model="form.code"  @change="vInput($event)"  :class="{ 'has-danger': errors.code }"  class="form-control required" id="">
                  <option value="">Choose Code</option>
                  <template v-for="(map, k) in codes">
                    <option v-for="(code, index) in map" :key="index" :value="code">
                      {{ index }} (+{{ code }})
                    </option>
                  </template>
                </select>
              </div>
              <div class="form-group bmd-form-group col-md-4 col-9">
                <label class="bmd-label-floating">Phone number</label>
                <input type="text" class="form-control  required" name="phone_number" v-model="form.phone_number"
                  @input="removeError($event)" @blur="vInput($event)" :class="{ 'has-danger': errors.phone_number }" />

                <span v-if="errors.phone_number">
                  <strong class="text-danger text-size-2">{{
                    formatError(errors.phone_number)
                  }}</strong>
                </span>
              </div>
              <div class="form-group bmd-form-group col-md-5 col-12">
                <label class="bmd-label-floating">Email address</label>
                <input id="email" type="email" class="form-control  required" name="email" v-model="form.email"
                  @input="removeError($event)" @blur="vInput($event)" :class="{ 'has-danger': errors.email }" />

                <span v-if="errors.email">
                  <strong class="text-danger text-size-2">{{
                    formatError(errors.email)
                  }}</strong>
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- <bookings v-for="booking in bookings" :key="booking.id" :booking="booking" :booking_details="booking_details"
          :property="property" @addExtraService="addExtraService" :bookings="bookings" /> -->

        <template v-if="property.extra_services.length">



          <div class=" bg-white mt-3">
            <h3 class="card-title  p-3 custom-border-bottom mb-0 bold-3">
              You may be intrested in
            </h3>
            <div class="card-body pt-0">

              <property-extras :extra_service="extra_service" v-for="extra_service in property.extra_services"
                :key="extra_service.id" :property="property" @addExtraPropertyService="addExtraPropertyService" />
            </div>
          </div>
        </template>

        <div class="d-block d-sm-none">
          <price-details :bookings="bookings" :property="property" :booking_details="booking_details"
            :amount="bookingTotal" :sub_total="bookingSubTotal" />
        </div>

        <rules :property="property" />

        <div class=" bg-white  mt-3">
       
          <div class="card-">
            <div class="custom-border-bottom ">
              <div class="d-flex justify-content-between align-items-center p-2 px-3 pb-3 ">
                <h3 class="card-title payment  mb-0 bold-3">
                  Payment Method
                </h3>

                <div class="payment-icons d-flex justify-content-center align-items-center">
                 
                  <div class="payment-image mr-3">
                    <img src="/img/bank-transfer.jpeg" class="img-fluid" alt="make payment with mastercard" />
                  </div>
                  <div class="payment-image mr-3">
                    <img src="/img/business.png" class="img-fluid" alt="make payment with mastercard" />
                  </div>
                  <div class="payment-image mr-3">
                    <img class="img-fluid" src="/img/visa-card-ohram.png" alt="make payment with mastercard" />
                  </div>
                  <div class="payment-image">
                    <img src="/img/Verve.png" class="img-fluid" alt="make payment with mastercard" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-body pt-0">



            <price-details :voucher="voucher" :bookings="bookings" :property="property" :booking_details="booking_details"
              :amount="amount" :sub_total="bookingSubTotal" />

            <div class="cart-discount mb-0 p-3 mt-3 col-sm-12">
              <h4>Apply Discount Code</h4>
              <div class="row g-0">
                <div class="col-8"><input v-model="coupon" type="text" class="form-control b" placeholder="Enter  code"
                    required=""></div>
                <div class="col-4"><button @click.prevent="applyCoupon"
                    class="btn btn-sm w-100 rounded-0 coupon-button btn-primary bg-main bold fs-3 text-white"
                    type="submit">
                    <span v-if="submiting" class="spinner-border spinner-border-sm" role="status"
                      aria-hidden="true"></span>
                    Apply </button></div>
              </div><!---->

              <!-- End .input-group -->
              <div v-if="coupon_error" class="text- text-danger">
                {{ coupon_error }}
              </div>
            </div>
            <div class="primary-color p-3">
              By clicking on the button below, I acknowledge that I have read
              and understand the rules and regulations of this property
            </div>
            <p class="form-group mt-3">
              <button type="buttom" @click.prevent="makePayment()" data-total=""
                class=" ml-1 btn btn-primary btn-round  btn-block  auth-form-button">
                <div class="auth-spinner d-none">
                  spinner
                </div>
                <span class="lt bold-2 text-white">{{ order_text }}</span>
              </button>
            <div class="primary-color p-3">
              Read
              <a class="text-info bold-2" target="_blank" href="https://avenuemontaigne.ng/pages/cancellation-policy">
                Cancellation Policy</a> of this property
            </div>
            </p>
          </div>
        </div>
      </form>
    </div>
    <div v-if="!paymentIsComplete" class="col-md-5 d-none d-lg-block">
      <price-details :voucher="voucher" :bookings="bookings" :property="property" :booking_details="booking_details"
        :amount="amount" :sub_total="bookingSubTotal" />
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import PriceDetails from "./PriceDetails.vue";
import Bookings from "./Bookings.vue";
import BookingLogin from "./BookingLogin.vue";
import BookingProperty from "./Property.vue";
import PropertyExtras from "./PropertyExtras.vue";
import BookingComplete from "./BookingComplete.vue";
import Rules from "./Rules.vue";

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
      codes: [
        { UK: "44" },
        { USA: "1" },
        { Algeria: "213" },
        { Andorra: "376" },
        { Angola: "244" },
        { Anguilla: "1264" },
        { "Antigua & Barbuda": "1268" },
        { Argentina: "54" },
        { Armenia: "374" },
        { Aruba: "297" },
        { Australia: "61" },
        { Austria: "43" },
        { Azerbaijan: "994" },
        { Bahamas: "1242" },
        { Bahrain: "973" },
        { Bangladesh: "880" },
        { Barbados: "1246" },
        { Belarus: "375" },
        { Belgium: "32" },
        { Belize: "501" },
        { Benin: "229" },
        { Bermuda: "1441" },
        { Bhutan: "975" },
        { Bolivia: "591" },
        { "Bosnia Herzegovina": "387" },
        { Botswana: "267" },
        { Brazil: "55" },
        { Brunei: "673" },
        { Bulgaria: "359" },
        { "Burkina Faso": "226" },
        { Burundi: "257" },
        { Cambodia: "855" },
        { Cameroon: "237" },
        { Canada: "1" },
        { "Cape Verde Islands": "238" },
        { "Cayman Islands": "1345" },
        { "Central African Republic": "236" },
        { Chile: "56" },
        { China: "86" },
        { Colombia: "57" },
        { Comoros: "269" },
        { Congo: "242" },
        { "Cook Islands": "682" },
        { "Costa Rica": "506" },
        { Croatia: "385" },
        { Cuba: "53" },
        { "Cyprus North": "90392" },
        { "Cyprus South": "357" },
        { "Czech Republic": "42" },
        { Denmark: "45" },
        { Djibouti: "253" },
        { Dominica: "1809" },
        { "Dominican Republic": "1809" },
        { Ecuador: "593" },
        { Egypt: "20" },
        { "El Salvador": "503" },
        { "Equatorial Guinea": "240" },
        { Eritrea: "291" },
        { Estonia: "372" },
        { Ethiopia: "251" },
        { "Falkland Islands": "500" },
        { "Faroe Islands": "298" },
        { Fiji: "679" },
        { Finland: "358" },
        { France: "33" },
        { "French Guiana": "594" },
        { "French Polynesia": "689" },
        { Gabon: "241" },
        { Gambia: "220" },
        { Georgia: "7880" },
        { Germany: "49" },
        { Ghana: "233" },
        { Gibraltar: "350" },
        { Greece: "30" },
        { Greenland: "299" },
        { Grenada: "1473" },
        { Guadeloupe: "590" },
        { Guam: "671" },
        { Guatemala: "502" },
        { Guinea: "224" },
        { "Guinea - Bissau": "245" },
        { Guyana: "592" },
        { Haiti: "509" },
        { Honduras: "504" },
        { "Hong Kong": "852" },
        { Hungary: "36" },
        { Iceland: "354" },
        { India: "91" },
        { Indonesia: "62" },
        { Iran: "98" },
        { Iraq: "964" },
        { Ireland: "353" },
        { Israel: "972" },
        { Italy: "39" },
        { Jamaica: "1876" },
        { Japan: "81" },
        { Jordan: "962" },
        { Kazakhstan: "7" },
        { Kenya: "254" },
        { Kiribati: "686" },
        { "Korea North": "850" },
        { "Korea South": "82" },
        { Kuwait: "965" },
        { Kyrgyzstan: "996" },
        { Laos: "856" },
        { Latvia: "371" },
        { Lebanon: "961" },
        { Lesotho: "266" },
        { Liberia: "231" },
        { Libya: "218" },
        { Liechtenstein: "417" },
        { Lithuania: "370" },
        { Luxembourg: "352" },
        { Macao: "853" },
        { Macedonia: "389" },
        { Madagascar: "261" },
        { Malawi: "265" },
        { Malaysia: "60" },
        { Maldives: "960" },
        { Mali: "223" },
        { Malta: "356" },
        { "Marshall Islands": "692" },
        { Martinique: "596" },
        { Mauritania: "222" },
        { Mayotte: "269" },
        { Mexico: "52" },
        { Micronesia: "691" },
        { Moldova: "373" },
        { Monaco: "377" },
        { Mongolia: "976" },
        { Montserrat: "1664" },
        { Morocco: "212" },
        { Mozambique: "258" },
        { Myanmar: "95" },
        { Namibia: "264" },
        { Nauru: "674" },
        { Nepal: "977" },
        { Netherlands: "31" },
        { "New Caledonia": "687" },
        { "New Zealand": "64" },
        { Nicaragua: "505" },
        { Niger: "227" },
        { Nigeria: "234" },
        { Niue: "683" },
        { "Norfolk Islands": "672" },
        { "Northern Marianas": "670" },
        { Norway: "47" },
        { Oman: "968" },
        { Palau: "680" },
        { Panama: "507" },
        { "Papua New Guinea": "675" },
        { Paraguay: "595" },
        { Peru: "51" },
        { Philippines: "63" },
        { Poland: "48" },
        { Portugal: "351" },
        { "Puerto Rico": "1787" },
        { Qatar: "974" },
        { Reunion: "262" },
        { Romania: "40" },
        { Russia: "7" },
        { Rwanda: "250" },
        { "San Marino": "378" },
        { "Sao Tome & Principe": "239" },
        { "Saudi Arabia": "966" },
        { Senegal: "221" },
        { Serbia: "381" },
        { Seychelles: "248" },
        { "Sierra Leone": "232" },
        { Singapore: "65" },
        { "Slovak Republic": "421" },
        { Slovenia: "386" },
        { "Solomon Islands": "677" },
        { Somalia: "252" },
        { "South Africa": "27" },
        { Spain: "34" },
        { "Sri Lanka": "94" },
        { "St. Helena": "290" },
        { "St. Kitts": "1869" },
        { "St. Lucia": "1758" },
        { Sudan: "249" },
        { Suriname: "597" },
        { Swaziland: "268" },
        { Sweden: "46" },
        { Switzerland: "41" },
        { Syria: "963" },
        { Taiwan: "886" },
        { Tajikstan: "7" },
        { Thailand: "66" },
        { Togo: "228" },
        { Tonga: "676" },
        { "Trinidad & Tobago": "1868" },
        { Tunisia: "216" },
        { Turkey: "90" },
        { Turkmenistan: "993" },
        { "Turks & Caicos Islands": "1649" },
        { Tuvalu: "688" },
        { Uganda: "256" },
        { Ukraine: "380" },
        { "United Arab Emirates": "971" },
        { Uruguay: "598" },
        { Uzbekistan: "7" },
        { Vanuatu: "678" },
        { "Vatican City": "379" },
        { Venezuela: "58" },
        { Vietnam: "84" },
        { "Virgin Islands - British": "1284" },
        { "Virgin Islands - US": "1340" },
        { "Wallis & Futuna": "681" },
        { Zambia: "260" },
        { Zimbabwe: "263" },
      ],
      coupon: null,
      amount: this.booking_details.total,
      tracking_id: null,
      payment_method: null,
      paymentIsComplete: null,
      coupon_error: null,
      payment_is_processing: null,
      voucher: [],
      order_text: "Make reservation",
      error: null,
      errorsBag: [],
      form: {
        first_name: null,
        last_name: null,
        email: null,
        code: "",
        phone_number: null,
        services: [],
        total: this.amount,
        booking_ids: this.booking_details.booking_ids,
        property_id: this.property.id,
        coupon: this.coupon_code,
        property_services: [],
      },
    };
  },
  computed: {
    ...mapGetters({
      user: "user",
      userType: "userType",
      bookings: "bookings",
      errors: "errors",
      bookingTotal: "bookingTotal",
      bookingSubTotal: "bookingSubTotal",
      bookingPropertyServicesTotal: "bookingPropertyServicesTotal",
      bookingServicesTotal: "bookingServicesTotal",
    }),
  },
  created() {
    this.scriptLoaded = new Promise((resolve) => {
      this.loadScript(() => {
        resolve();
      });
    });

    this.amount = this.booking_details.total;
    this.$store.commit("setBookings", this.apartments);
    this.$store.commit("setBookingTotal", this.booking_details.total);
    this.$store.commit("setBookingSubTotal", this.booking_details.total);
    
  },
  mounted() {
    document.getElementById("full-bg").remove();
    let payload = {
        page_url: window.location.href,
        apartment_id: this.booking_details.apt_id
      }
    axios
      .post('/abandoned-cart', payload)
      .then((res) => {
        this.tracking_id = res.data.id // 👈 Store tracking ID
      })
      .catch((err) => {
        console.error('Error sending abandoned cart payload:', err)
      })


  },
  components: {
    PriceDetails,
    Bookings,
    BookingProperty,
    BookingLogin,
    PropertyExtras,
    BookingComplete,
    Rules,
  },
  methods: {
    ...mapActions({
      applyVoucher: "applyVoucher",
      validateForm: "validateForm",
      clearErrors: "clearErrors",
      checkInput: "checkInput",
    }),
    formatError(error) {
      return Array.isArray(error) ? error[0] : error;
    },
    removeError(e) {
      let input = document.querySelectorAll(".required");
      if (typeof input !== "undefined") {
        this.clearErrors({ context: this, input: input, e });
      }
    },
    vInput(e) {
      let input = document.querySelectorAll(".required");
      if (typeof input !== "undefined") {
        this.checkInput({
          context: this,
          email: this.form.email,
          input: input,
          e,
        });
      }
    },
    addExtraService({ extras }) {
      this.form.services = extras;
    },
    addExtraPropertyService({ extras }) {
      this.form.property_services = extras;
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

    applyCoupon: function () {
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
          total: this.bookingTotal,
          limit: this.booking_details.days,
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

    scrollToPosition(x, y, duration) {
      const start = performance.now();
      const startX = window.scrollX;
      const startY = window.scrollY;

      const step = (timestamp) => {
        let progress = timestamp - start;
        if (progress > duration) progress = duration;
        const percentage = progress / duration;

        const newX = startX + (x - startX) * percentage;
        const newY = startY + (y - startY) * percentage;
        window.scrollTo(newX, newY);

        if (progress < duration) {
          window.requestAnimationFrame(step);
        }
      };

      window.requestAnimationFrame(step);
    },
    makePayment: function () {
      let input = document.querySelectorAll(".required");
      this.validateForm({ context: this, input: input });
      if (Object.keys(this.errors).length !== 0) {
        this.error = "Please check for errors";
        this.scrollToPosition(200, 200, 1000)
        return false;
      }

      this.payment_is_processing = true;
      let context = this;
      context.order_text = "Processing.......";

      let payload = {
        first_name: this.form.first_name,
        last_name: this.form.last_name,
        email: this.form.email,
        code: this.form.code,
        phone_number: this.form.phone_number,
        services: this.form.services,
        currency: this.booking_details.currency,
        total: context.voucher.length ? context.voucher[0].sub_total : context.bookingPropertyServicesTotal +
          context.bookingServicesTotal +
          context.bookingTotal
        ,
        booking_ids: context.booking_details.booking_ids,
        property_id: context.property.id,
        coupon: this.coupon_code,
        property_services: this.form.property_services,
        original_amount: context.bookingPropertyServicesTotal +
          context.bookingServicesTotal +
          context.bookingTotal,
        page_url: window.location.href,
        session_id: this.booking_details.sessionId,
        apartment_id: this.booking_details.apt_id
      }
    
      axios
        .put('/abandoned-cart/' + this.tracking_id, payload)
        
      
      //pk_test_c5b3db1649d534eec8ab6a35ed696ad624e3070a

      var handler = PaystackPop.setup({
        key: "pk_live_c5fd554e0bc5c39d5f8f14b5f2a6263a403b9e55", //'pk_live_c5fd554e0bc5c39d5f8f14b5f2a6263a403b9e55',//'pk_test_844112398c9a22ef5ca147e85860de0b55a14e7c',
        email: payload.email,
        amount: payload.total * 100,
        currency: context.booking_details.currency,
        first_name: payload.first_name,
        metadata: {
          custom_fields: [
            {
              booking: payload,
              tracking_id: context.tracking_id
            },
          ],
        },
        callback: function (response) {
          localStorage.clear();
          context.payment_is_processing = false;
          context.paymentIsComplete = true;
        },
        onClose: function () {
          context.order_text = "Make Payment";
          context.payment_is_processing = false;
        },
      });
      handler.openIframe();


    },
  },
};
</script>
