<template>
  <div class="form-group mb-4">
    <div class="input-group input-group-lg">
      <div class="input-group-prepend ">
        <span
          class="input-group-text  border-0 text-muted fs-18"
          id="inputGroup-sizing-lg"
        >
          <i class="fas fa-location"></i>
        </span>
      </div>
      <input
        type="text"
        class="form-control  shadow-none fs-13"
        id="location"
        name="location"
        required="true"
        placeholder="Where are you going"
        autocomplete="off"
      />
    </div>
    <div id="myInputautocomplete-list" class="autocomplete-items">
      <div>
        <i class="far fa-map-marker-alt mr-1"></i> <strong>Poland</strong>
        <div>Ikeja, Lagos, Nigeria</div>
        <input type="hidden" value="Poland" />
      </div>
      <div>
        <i class="far fa-map-marker-alt  mr-1"></i>
        <strong>Portugal</strong>
        <input type="hidden" value="Portugal" />
      </div>
    </div>
  </div>
</template>
<script>
export default {};
</script>

<style>
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 73%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
  text-align: left;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9;
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important;
  color: #ffffff;
}
</style>
