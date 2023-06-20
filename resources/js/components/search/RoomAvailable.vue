<template>
  <div class="container">
    <div class="row  align-items-start">
      <div class="col-md-6">
        <h1>Your Details</h1>
        <login-register />

        <div class="bg--light mt-3">
          <div class="">
            <span class="float-right">
              <div class="payment-icons mt-1 d-flex">
                <div class="payment-image ms mr-3">
                  <img
                    width="50"
                    height="50"
                    src="/img/business.png"
                    alt="make payment with mastercard"
                  />
                </div>
                <div class="payment-image mr-3">
                  <img
                    width="50"
                    height="50"
                    src="/img/visa-card-ohram.png"
                    alt="make payment with mastercard"
                  />
                </div>

                <div class="payment-image">
                  <img
                    src="/img/Verve.png"
                    width="50"
                    height="50"
                    alt="make payment with mastercard"
                  />
                </div>
              </div>
            </span>
            <h3>2. PAYMENT</h3>
          </div>
          <cart-index
            :apartments="apartments"
            :booking_details="booking_details"
          />
          <div class="input-group mb-1">
            <input
              type="text"
              class="form-control"
              placeholder="Have a coupon? Enter here"
              aria-label="coupon"
              aria-describedby="coupon"
              v-model="coupon"
            />
            <div class="input-group-append">
              <button
                @click.prevent="applyCoupon"
                class="btn btn-outline-secondary"
                type="button"
              >
                <span
                  v-if="submiting"
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                ></span>
                Apply Coupon
              </button>
            </div>
          </div>
          <div v-if="coupon_error" class="text-capitalize bold text-danger">
            {{ coupon_error }}
          </div>

          <div
            class="card-footer bg-transparent d-flex justify-content-between p-0 align-items-center"
          >
            <p class="text-heading mb-0">Total Price:</p>
            <template v-if="voucher.length">
              <span>
                <span class="fs-32 font-weight-bold text-heading">
                  {{ booking_details.currency }}{{ amount }}
                  <del
                    >{{ booking_details.currency
                    }}{{ booking_details.total }}</del
                  >
                </span>
                <p class="retail-title">{{ voucher[0].percent }}</p>
              </span>
            </template>
            <template v-else>
              <span class="fs-32 font-weight-bold text-heading"
                >{{ booking_details.currency }}{{ booking_details.total }}</span
              >
            </template>
          </div>
          <div class="form-row">
            <div class="col-md-12">
              <button
                @click="payWithPaystack"
                type="buuton"
                class="btn btn-block  btn-primary"
              >
                Make Payment
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6   d-none d-lg-block">
        <h1 class="bold">Your booking details</h1>
        <cart-index
          :apartments="apartments"
          :booking_details="booking_details"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import LoginRegister from "../auth/LoginRegister";
import CartIndex from "../cart/Index";
import axios from "axios";

export default {
  props: ["apartments", "booking_details"],
  data() {
    return {
      scriptLoaded: null,
      paymentIsComplete: false,
      submiting: false,
      coupon_code: null,
      coupon: null,
      amount: 0,
      payment_method: null,
      coupon_error: null,
      voucher: [],
      order_text: null,
      error: null,
    };
  },
  computed: {
    ...mapGetters({
      user: "user",
      userType: "userType",
    }),
  },
  created() {
    this.scriptLoaded = new Promise((resolve) => {
      this.loadScript(() => {
        resolve();
      });
    });
    if (this.$root.loggedIn) {
      this.$store.commit("setShowForm", false);
      this.$store.commit("setUser", this.$root.user);
      this.$store.commit("setEditMode", true);
      this.$store.commit("setUserType", "registered");
    } else {
      this.$store.commit("setShowForm", true);
    }
  },
  components: {
    LoginRegister,
    CartIndex,
  },
  methods: {
    ...mapActions({
      applyVoucher: "applyVoucher",
    }),
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
    payWithPaystack: function() {
      //let form = document.getElementById("checkout-form-2");
      this.amount = this.amount != 0 ? this.amount : this.booking_details.total;
      let context = this;
      this.payment_method = "card";
      var handler = PaystackPop.setup({
        key: "pk_test_c5b3db1649d534eec8ab6a35ed696ad624e3070a",
        email: context.user.email,
        amount: context.amount * 100,
        currency: "NGN",
        first_name: context.user.name,
        metadata: {
          custom_fields: [
            {
              user_type: context.userType,
              coupon: context.coupon_code,
              user_id: context.user.id,
              total: context.amount,
              currency: context.booking_details.currency,
              apartment_quantity: context.booking_details.apartment_quantity,
              range: context.booking_details.date_range,
              property_id: context.booking_details.property_id,
            },
          ],
        },
        callback: function(response) {
          axios
            .post("/webhook/payment", {
              user_type: context.userType,
              coupon: context.coupon_code,
              user_id: context.user.id,
              total: context.amount,
              currency: context.booking_details.currency,
              apartment_quantity: context.booking_details.apartment_quantity,
              range: context.booking_details.date_range,
              property_id: context.booking_details.property_id,
            })
            .then((response) => {
              this.submiting = false;
              //this.amount = parseInt(response.data.sub_total);
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
