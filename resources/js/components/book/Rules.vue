<template>
  <div class=" bg-white mt-3">
    <h3 class="card-title  p-3 custom-border-bottom mb-0 bold-3">
      Important Trip Information
    </h3>
    <div class="card-body pt-0">
      <div>
        <h5 class="bold-2">House Rules</h5>
        <ul class="list-unstyled">
          <li class="">
            <p class=" text-heading mb-0">
              Check-in -- {{ property.check_in_time }}
            </p>
          </li>
          <li class="">
            <p class="font-weight-500 text-heading mb-0">
              Check-out -- {{ property.check_out_time }}
            </p>
          </li>

          <li v-for="rule in property.rules" :key="rule.id" class="">
            <p class="font-weight-500 text-heading mb-0">
              {{ rule.name }}
            </p>
          </li>
        </ul>
      </div>
      <div v-if="property.cancellation_message">
        <h5>Other Information</h5>
        <ul class="list-unstyled">
          <li class="">
            <p class="font-weight-500 text-heading mb-0">
              {{ property.cancellation_message }}
            </p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["property"],
};
</script>
