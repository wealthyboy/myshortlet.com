<template>
  <div class=" bg-white">
    <h4 class="card-title p-3 border-bottom">
      Important Trip Information
    </h4>
    <div class="card-body">
      <div>
        <h5>House Rules</h5>
        <ul class="list-unstyled">
          <li class="">
            <p class="font-weight-500 text-heading mb-0">
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
      <div>
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
