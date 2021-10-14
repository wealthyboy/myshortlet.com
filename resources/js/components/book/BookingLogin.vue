<template>
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
</template>
<script>
export default {};
</script>
