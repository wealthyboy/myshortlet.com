<template>
  <form
    @submit.prevent="authenticate"
    v-if="!$root.loggedIn && !loggedIn"
    class="mb-5"
  >
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="lEmail">Email</label>
        <input
          type="email"
          class="form-control required"
          id="lEmail"
          placeholder="Email"
          v-model="email"
          required
        />
        <span v-if="errors.email">
          <small class="text-danger">{{ formatError(errors.email) }}</small>
        </span>
      </div>
      <p class="text-danger bold" v-if="errors.length">
        Email/Password not found
      </p>

      <div class="form-group col-md-6">
        <label for="lPassword">Password</label>
        <input
          type="password"
          class="form-control required"
          id="lPassword"
          placeholder="Password"
          v-model="password"
          name="password"
          required
        />
      </div>
    </div>
    <div class="form-row">
      <div class=" col-md-12">
        <button
          type="submit"
          :class="{ disabled: loading }"
          class="btn btn-block  btn-primary"
        >
          <span
            v-if="loading"
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
          ></span>
          Login
        </button>
      </div>
    </div>
  </form>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      email: "",
      password: "",
      loading: false,
      redirect: false,
    };
  },

  created() {
    console.log(34);
  },
  computed: {
    ...mapGetters({
      errors: "errors",
      loggedIn: "loggedIn",
    }),
  },

  methods: {
    ...mapActions({
      login: "login",
      validateForm: "validateForm",
      clearErrors: "clearErrors",
      checkInput: "checkInput",
    }),

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
