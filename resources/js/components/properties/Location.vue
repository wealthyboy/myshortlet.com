<template>
  <div>
    <label class="pl-4" for="Location-input">Location</label>

    <div class="input-group input-group-lg">
      <div class="input-group-prepend">
        <span
          class="input-group-text  border-0 text-muted fs-18"
          id="inputGroup-sizing-lg"
        >
          <i class="fas fa-map-marker-alt"></i>
        </span>
      </div>
      <input
        type="text"
        class="form-control ml-2"
        name="going_to"
        value=""
        id="Location-input"
        placeholder="Where are you going"
      />
    </div>
  </div>
</template>
<script>
export default {};
</script>
