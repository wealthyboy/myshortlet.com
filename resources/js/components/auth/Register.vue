<template>
  <div v-if="showForm">
    <div v-if="!edit" class="class">Or</div>
    <form method="POST" @submit.prevent="submit" class="" action="#">
      <span v-if="errors.general">
        <small class="text-danger">{{ formatError(errors.general) }}</small>
      </span>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="First_Name">First Name</label>
          <input
            type="text"
            v-model="form.first_name"
            class="form-control required"
            id="First_Name"
            placeholder="First Name"
            @input="removeError($event)"
            @blur="vInput($event)"
            :class="{ 'has-danger': errors.last_name }"
            name="first_name"
          />
          <span v-if="errors.last_name">
            <small class="text-danger">{{
              formatError(errors.first_name)
            }}</small>
          </span>
        </div>
        <div class="form-group col-md-6">
          <label for="Last_Name">Last Name</label>
          <input
            v-model="form.last_name"
            type="text"
            class="form-control required"
            id="Last_Name"
            placeholder="Last Name"
            @input="removeError($event)"
            @blur="vInput($event)"
            :class="{ 'has-danger': errors.last_name }"
            name="last_name"
          />
          <span v-if="errors.last_name">
            <small class="text-danger">{{
              formatError(errors.last_name)
            }}</small>
          </span>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="Email">Email</label>
          <input
            type="email"
            class="form-control  required"
            id="Email"
            placeholder="Email"
            v-model="form.email"
            @input="removeError($event)"
            @blur="vInput($event)"
            :class="{ 'has-danger': errors.email }"
            value=""
            name="email"
          />
          <span v-if="errors.email">
            <small class="text-danger">{{ formatError(errors.email) }}</small>
          </span>
        </div>
        <div class="form-group col-md-6">
          <label for="Phone">Phone Number</label>
          <input
            v-model="form.phone_number"
            type="text"
            class="form-control  required"
            id="Phone"
            placeholder="Phone Number"
            @input="removeError($event)"
            @blur="vInput($event)"
            :class="{ 'has-danger': errors.phone_number }"
            value=""
            name="phone_number"
          />
          <span v-if="errors.phone_number">
            <small class="text-danger">{{
              formatError(errors.phone_number)
            }}</small>
          </span>
        </div>
      </div>

      <div v-if="!edit" class="form-row">
        <div class="form-group col-md-6">
          <label for="Password">Password</label>
          <input
            type="password"
            class="form-control "
            id="Password"
            v-model="form.password"
            placeholder="Password"
            value=""
          />
          <span v-if="errors.password">
            <small class="text-danger">{{
              formatError(errors.password)
            }}</small>
          </span>
        </div>
        <div v-if="!edit" class="form-group col-md-6">
          <label for="Confirm_Password">Confirm Password</label>
          <input
            type="password"
            class="form-control  required"
            id="Confirm_Password"
            placeholder="Confirm Password"
            value=""
            name="password_confirmation"
            v-model="form.password_confirmation"
          />
          <span v-if="errors.password_confirmation">
            <small class="text-danger">{{
              formatError(errors.password_confirmation)
            }}</small>
          </span>
        </div>
      </div>

      <div class="form-row justify-content-end">
        <div v-if="edit" class="col-6">
          <button
            @click.prevent="cancelForm"
            type="button"
            class="btn btn-block  btn-primary"
          >
            Cancel
          </button>
        </div>
        <div class="col-6">
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
            Save & Continue
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      loading: false,
      errorsBag: [],
      form: {
        email: "",
        password: "",
        first_name: null,
        last_name: null,
        password_confirmation: null,
        phone_number: null,
      },
    };
  },
  computed: {
    ...mapGetters({
      errors: "errors",
      showForm: "showForm",
      loggedIn: "loggedIn",
      edit: "edit",
    }),
  },
  created() {
    if (this.$root.loggedIn) {
      this.form.first_name = this.$root.user.name;
      this.form.last_name = this.$root.user.last_name;
      this.form.email = this.$root.user.email;
      this.form.phone_number = this.$root.user.phone_number;
    }
  },
  methods: {
    ...mapActions({
      register: "register",
      validateForm: "validateForm",
      clearErrors: "clearErrors",
      checkInput: "checkInput",
      updateProfile: "updateProfile",
      registerGuest: "registerGuest",
    }),
    formatError(error) {
      return Array.isArray(error) ? error[0] : error;
    },
    cancelForm: function() {
      this.$store.commit("setShowForm", false);
      this.$store.commit("setEditMode", false);
    },
    removeError(e) {
      let input = document.querySelectorAll(".required");
      if (typeof input !== "undefined") {
        this.clearErrors({ context: this, input: input });
      }
    },
    vInput(e) {
      let input = document.querySelectorAll(".required");
      if (typeof input !== "undefined") {
        this.checkInput({ context: this, email: this.form.email, input: e });
      }
    },
    submit: function() {
      let input = document.querySelectorAll(".required");
      //this.validateForm({ context: this, input: input });
      // if (Object.keys(this.errors).length !== 0) {
      //   this.error = "Please check for errors";
      //   return false;
      // }
      this.loading = true;
      if (!this.form.password && !this.edit) {
        this.registerGuest({
          form: this.form,
          context: this,
        }).then(() => {
          this.loading = false;
        });
        return;
      }

      if (this.edit) {
        this.updateProfile({
          form: this.form,
          id: this.$root.user.id,
          context: this,
        }).then(() => {
          this.loading = false;
        });
        return;
      } else {
        this.register({
          context: this,
        });
      }
    },
  },
};
</script>
