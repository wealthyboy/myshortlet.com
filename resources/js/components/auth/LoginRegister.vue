<template>
  <section class="">
    <login />
    <register />
    <profile />
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Login from "./Login.vue";
import Register from "./Register.vue";
import Profile from "./Profile.vue";

export default {
  data() {
    return {
      email: "",
      password: "",
      loading: false,
      redirect: false,
    };
  },
  components: {
    Login,
    Register,
    Profile,
  },

  computed: {
    ...mapGetters({
      errors: "errors",
      loggedIn: "loggedIn",
    }),
  },
  formatError(error) {
    return Array.isArray(error) ? error[0] : error;
  },
  methods: {
    ...mapActions({
      login: "login",
    }),
    editProfile: function(index) {
      let address = this.addresses[index];
      this.form.first_name = address.first_name;
      this.form.last_name = address.last_name;
      this.form.email = address.email;
      this.form.phone_number = address.phone_number;
      this.form.address = address.address;
      this.form.city = address.city;
      this.form.postal_code = address.postal_code;
      this.form.country_id = address.country_id;
      let state = [];
      let ship_prices = [];
      this.getState(address.country_id);
      this.form.state_id = address.state_id;
      this.edit = true;
      this.address_id = address.id;
      this.$store.commit("setShowForm", true);
    },
    authenticate: function() {
      this.loading = true;
      this.login({
        email: this.email,
        password: this.password,
        redirect: false,
        context: this,
      }).catch((error) => {
        this.loading = false;
        this.errors = error.response.data.error || error.response.data.errors;
      });
    },
  },
};
</script>
