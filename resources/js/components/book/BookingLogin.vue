<template>
  <div class="main-background mt-1">
    <div class="card-body">
      <div v-if="!booking_details.loggedIn">
        <a data-toggle="modal" href="#" data-to="login" data-target="#loadModal" class="auth-form text-white bold-3">Sign
          in</a>
        <span class="text-white">to book with your saved details. It helps to track your record!
        </span>
      </div>

      <div class="text-white" v-if="booking_details.loggedIn">
        You are signed in as {{ booking_details.user.email }}
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    booking_details: Object,
  }
};
</script>
