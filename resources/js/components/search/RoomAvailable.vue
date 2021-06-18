<template lang="pug">
    <div class="text-center bg-light">
   <div class="col-md-11 p-lg-5 mx-auto my-5">
      <h1 class="display-4 font-weight-normal">.</h1>
      <form  action="/search" method="GET">
         <div class="form-row">
            
            <div class="col-md-3">
               <div class="form-group mb-4">
                  <div class="input-group input-group-lg">
                     <div class="input-group-prepend">
                        <span
                           class="input-group-text  border-0 text-muted fs-18"
                           id="inputGroup-sizing-lg"
                           >
                        <i class="fal fa-calendar-week"></i>
                        </span>
                     </div>
                     <input
                        type="text"
                        class="form-control  shadow-none fs-13"
                        id="flatpickr-input-f"
                        name="check_in_check_out"
                        placeholder="Check in-Check out"
                        />
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <persons />
            </div>
            <div class="col-md-2">
               <button type="submit" class="btn btn-block btn-primary">Search</button>
            </div>
         </div>
      </form>
   </div>
</div>
</template>
<script>
export default {
  data() {
    return {
      rooms: 1,
    };
  },

  methods: {},
};
</script>
