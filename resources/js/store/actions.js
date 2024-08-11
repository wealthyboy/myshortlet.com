import axios from "axios";

import store from "./index";

export const flashMessage = ({ commit }, message) => {
  commit("setMessage", message);
  setTimeout(() => {
    commit("clearMessage");
  }, 3000);
};

export const applyVoucher = ({ commit }, coupon) => {
  axios
    .post("/checkout/coupon", {
      coupon: coupon,
    })
    .then((response) => {
      commit("setCoupon", response.data);
      return Promise.resolve();
    })
    .catch((error) => {});
};

export const attrFilter = ({ commit }) => {
  var inputs = document.querySelectorAll("input.filter-property:checked");
  var checkboxesChecked = [];
  for (var i = 0; i < inputs.length; i++) {}
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].checked) {
      checkboxesChecked.push(inputs[i].name + "=" + inputs[i].value);
    }
  }
  commit("setAttributesCheckboxes", checkboxesChecked);
};

export const lSearch = ({ commit }) => {
  let locationSearch = [];
  document.querySelectorAll(".location-search").forEach((e, i) => {
    locationSearch.push(e.name + "=" + e.value);
  });
  commit("setLocationSearch", locationSearch);
};

export const getProperties = ({ commit }, url) => {
  commit("setPropertyLoading", true);
  return axios
    .get(url)
    .then((response) => {
      commit("setProperties", response.data.data);
      commit("setMeta", response.data.meta);
      commit("setAttributes", response.data.attributes);
      commit("setLinks", response.data.links);
      commit("setNextPageUrl", response.data.links.next);
      commit("setPropertyLoading", false);

      jQuery(function () {
        $(".owl-carousel").owlCarousel({
          margin: 10,
          nav: true,
          dots: false,
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
      commit("setPropertyLoading", false);
      commit("setProperties", []);
    });
};

export const updateCartMeta = ({ commit }, payload) => {
  commit("setCartMeta", payload);
};

export const updateBooking = (
  { commit },
  { product_variation_id, quantity }
) => {
  return axios
    .post("/api/cart", {
      product_variation_id: product_variation_id,
      quantity,
    })
    .then((response) => {
      commit("setBooking", response.data);
      //document.getElementById("icon-trigger").click();
      return Promise.resolve();
    });
};

export const getBookings = ({ commit }) => {
  commit("Loading", true);

  return axios
    .get("/api/cart")
    .then((response) => {
      commit("setBooking", response.data);
      //document.getElementById("js-loading").style.display = "none";
      //commit("Loading", false);
      return Promise.resolve();
    })
    .catch(() => {});
};

export const saveProperty = (
  { commit, dispatch },
  { property_id, context }
) => {
  return axios
    .post("/api/saved", {
      property_id: property_id,
    })
    .then((res) => {
      if (res.data.status == "added") {
        document
          .querySelector(".is_not_saved_" + property_id)
          .classList.add("d-none");
        document
          .querySelector(".is_saved_" + property_id)
          .classList.remove("d-none");
      } else {
        document
          .querySelector(".is_saved_" + property_id)
          .classList.add("d-none");
        document
          .querySelector(".is_not_saved_" + property_id)
          .classList.remove("d-none");
      }

      return Promise.resolve();
    })
    .catch((error) => {
      dispatch(
        "flashMessage",
        "Sorry your item could not be saved.Please try again"
      );
    });
};

export const deleteWishlist = ({ commit }, { id }) => {
  return axios.delete("/api/wishlist/delete/" + id + "").then((response) => {
    commit("appendToWishlist", response.data.data);
    return Promise.resolve();
  });
};

export const login = ({ commit }, { email, password, redirect, context }) => {
  return axios
    .post("/login", {
      email: email,
      password: password,
    })
    .then((response) => {
      if (redirect) {
        window.location.href = response.data.url;
      }
      commit("setLoggedIn", 1);
      commit("setUser", response.data.user);
      commit("setShowForm", false);
      commit("setUserType", response.data.user_type);
      commit("setEditMode", true);

      return Promise.resolve();
    })
    .catch((error) => {
      context.loading = false;
      if (typeof error.response.data.errors === "undefined") {
        commit("setFormErrors", {
          general: "We could register you.Please try again later",
        });
        return;
      }
      commit("setFormErrors", error.response.data.error);
    });
};

export const register = ({ commit }, { context, redirect = false }) => {
  return axios
    .post("/register", context.form)
    .then((response) => {
      if (redirect) {
        window.location.href = response.data.url;
      }
      commit("setLoggedIn", 1);
      commit("setUser", response.data.user);
      commit("setShowForm", false);
      commit("setUserType", response.data.user_type);
      commit("setEditMode", true);
    })
    .catch((error) => {
      context.loading = false;
      if (typeof error.response.data.errors === "undefined") {
        commit("setFormErrors", {
          general: "We could not register you.Please try again later",
        });
        return;
      }

      commit("setFormErrors", error.response.data.errors);
    });
};

export const updateProfile = ({ dispatch, commit }, { form, id }) => {
  return axios
    .put("/profile/" + id, {
      first_name: form.first_name,
      last_name: form.last_name,
      email: form.email,
      phone_number: form.phone_number,
    })
    .then((response) => {
      console.log(response);
      commit("setShowForm", false);
      commit("setUser", response.data.user);
      commit("setEditMode", false);
      return Promise.resolve();
    })
    .catch(() => {
      commit("setShowForm", true);
    });
};

export const registerGuest = ({ dispatch, commit }, { form }) => {
  return axios
    .post("/guests", {
      first_name: form.first_name,
      last_name: form.last_name,
      email: form.email,
      phone_number: form.phone_number,
    })
    .then((response) => {
      commit("setLoggedIn", 1);
      commit("setShowForm", false);
      commit("setUser", response.data.guest_user);
      commit("setUserType", response.data.user_type);
      return Promise.resolve();
    })
    .catch(() => {
      commit("setShowForm", true);
    });
};

export const deleteBooking = (
  { commit },
  { context, booking_id, property_id, amount }
) => {
  axios
    .post("delete/" + booking_id, {
      property_id: property_id,
    })
    .then((response) => {
      let total = parseInt(response.data.data.total);
      let t = parseInt(amount) + total;

      context.amount = t;

      console.log(context.amount);

      commit("setBookingSubTotal", total);
      commit("setBookings", response.data.data.bookings);
      commit("setBookingTotal", t);

      return Promise.resolve();
    });
};

export const updatePassword = ({ commit, dispatch }, { payload, context }) => {
  return axios
    .put("/change/password", payload)
    .then((response) => {
      context.loading = false;
      commit("setMessage", response.data.message);
    })
    .catch((error) => {
      context.loading = false;
      if (error.response.status == 500) {
        context.error =
          "We could not change your password at the moment .Please try again";
        return;
      }
      if (error.response.data.errors) {
        context.error = error.response.data.errors;
        commit("setFormErrors", error.response.data.errors);
      }
    });
};

export const resetPassword = ({ commit }, { payload, context }) => {
  return axios
    .post("/reset/password", payload)
    .then((response) => {
      context.loading = false;
      commit("setMessage", response.data.message);
    })
    .catch((error) => {
      context.loading = false;
      if (error.response.status == 500) {
        context.error = "We could not send your password reset link";
        commit("setFormErrors", "We could not send your password reset link");
        return;
      }
      if (error.response.data.errors) {
        commit("setFormErrors", error.response.data.errors);
        return;
      }
    });
};

export const updateLocations = ({ commit }, payload) => {
  commit("addToLocations", payload);
};

export const setADl = ({ commit }, response) => {
  commit("addToAddress", response.data.data);
  commit("addToLocations", response.data.meta.countries);
  commit("setShipping", response.data.meta.shipping);
  commit("setDefaultShipping", response.data.meta.default_shipping);
};

export const forgotPassword = ({ commit }, { payload, context }) => {
  return axios
    .post("/password/reset/link", payload)
    .then((response) => {
      context.loading = false;
      commit("setMessage", response.data.message);
    })
    .catch((error) => {
      context.loading = false;
      if (error.response.status == 500) {
        let errors = { general: "We could not send your password reset link" };
        commit("setFormErrors", errors);
        return;
      }
      if (error.response.data.errors) {
        commit("setFormErrors", error.response.data.errors);
      }
    });
};

export const createReviews = ({ commit }, { payload, context, form }) => {
  return axios
    .post("/reviews/store", form)
    .then((response) => {
      context.submiting = false;
      commit("setReviews", response.data.data);
    })
    .catch((error) => {
      context.submiting = false;
      if (error.response.status == 500) {
        let errors = { general: "We could not send your password reset link" };
        commit("setFormErrors", errors);
        return;
      }
      if (error.response.data.errors) {
        commit("setFormErrors", error.response.data.errors);
      }
    });
};

export const createComment = ({ commit }, { payload, context }) => {
  return axios
    .post("/blog", context.form)
    .then((response) => {
      context.submiting = false;
      commit("setComments", response.data.data);
    })
    .catch((error) => {
      context.submiting = false;
      if (error.response.status == 500) {
        let errors = { general: "We could not send your password reset link" };
        commit("setFormErrors", errors);
        return;
      }
      if (error.response.data.errors) {
        commit("setFormErrors", error.response.data.errors);
      }
    });
};

export const getReviews = ({ commit }, { context }) => {
  return axios
    .get("/reviews/" + context.product_slug)
    .then((response) => {
      context.loading = false;
      commit("setReviews", response.data.data);
    })
    .catch((error) => {
      context.loading = false;
      if (error.response.status == 500) {
        let errors = { general: "We could not send your password reset link" };
        commit("setFormErrors", errors);
        return;
      }
      if (error.response.data.errors) {
        commit("setFormErrors", error.response.data.errors);
      }
    });
};

export const clearError = ({ commit }) => {
  let errors = {};
  commit("setFormErrors", errors);
};

export const clearErrors = ({ commit }, { context, input, e }) => {
  const prop = e.target.name;
  delete context.errors[prop];
};

export const validateForm = ({ dispatch, commit }, { context, input }) => {
  let p = {},
    k,
    errors = [];
  if (input.length) {
    input.forEach(function (element, v) {
      console.log(element, v);
      if (element.value == "") {
        k = element.name.split("_").join(" ");
        errors = Object.assign({}, errors, {
          [element.name]: k + "  is required",
        });
      }
      if (element.name == "email") {
        let value = element.value;
        if (!validateEmail(value)) {
          p.email = "Please enter a valid email";
        }
      }

      if (element.name == "phone_number") {
        let value = element.value;
        if (!/^[0-9]+$/.test(value)) {
          p.phone_number = "Please enter a valid phone number";
        }
      }
    });
  }

  if (
    context.form.password !== "" &&
    typeof context.form.password_confirmation !== "undefined" &&
    context.form.password_confirmation !== ""
  ) {
    if (context.form.password !== context.form.password_confirmation) {
      p.password_confirmation = "Password do not match";
    }
  }
  errors = Object.assign({}, errors, p);
  commit("setFormErrors", errors);
};

export const checkInput = ({ commit }, { context, input, e }) => {
  validateForm({ commit }, { context, input, e });
};

export const validateEmail = (email) => {
  return ruleE().test(String(email).toLowerCase());
};

export const ruleE = () => {
  var re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re;
};
