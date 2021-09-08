<template>
  <div v-if="!showForm" class="border p-3">
    <h4 class="text-heading fs-22 font-weight-500 lh-15"></h4>
    <ul v-if="user" class="list-unstyled">
      <li class=" lh-22">
        <p class="text-gray-light mb-0">
          {{ user.name }}
          {{ user.last_name }}
        </p>
      </li>
      <li class=" lh-22">
        <p class="text-gray-light mb-0">{{ user.email }}</p>
      </li>
      <li class=" lh-22">
        <p class="text-gray-light mb-0">
          {{ user.phone_number }}
        </p>
      </li>
    </ul>
    <ul v-else-if="$root.user" class="list-unstyled">
      <li class=" lh-22">
        <p class="text-gray-light mb-0">
          {{ $root.user.name || user.name }}
          {{ $root.user.last_name || user.last_name }}
        </p>
      </li>
      <li class=" lh-22">
        <p class="text-gray-light mb-0">{{ $root.user.email || user.email }}</p>
      </li>
      <li class=" lh-22">
        <p class="text-gray-light mb-0">
          {{ $root.user.phone_number || user.phone_number }}
        </p>
      </li>
    </ul>
    <p>
      <a
        @click.prevent="editProfile"
        data-placement="left"
        href="#"
        class="ml-0 mr-4 color--primary bold"
      >
        <i class="fa fa-edit"></i> Edit
      </a>
    </p>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      loading: false,
    };
  },
  computed: {
    ...mapGetters({
      loggedIn: "loggedIn",
      showForm: "showForm",
      user: "user",
      edit: "edit",
    }),
  },
  formatError(error) {
    return Array.isArray(error) ? error[0] : error;
  },
  methods: {
    editProfile: function() {
      this.$store.commit("setShowForm", true);
      this.$store.commit("setEditMode", true);
    },
  },
};
</script>
