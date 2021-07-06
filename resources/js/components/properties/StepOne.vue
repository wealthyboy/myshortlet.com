<template>
  <div>
    <form action="" class="form-row">
      <div class="col-md-7">
        <div class="form-group">
          <label for="">Title</label>
          <input type="email" class="form-control" id="" placeholder="" />
        </div>

        <div class="form-group">
          <label for="">Description</label>
          <textarea class="form-control" id="" rows="3"></textarea>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="inputState">State</label>
            <select id="inputState" class="form-control">
              <option selected>Choose...</option>
              <option>...</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="inputState">City</label>
            <select id="inputState" class="form-control">
              <option selected>Choose...</option>
              <option>...</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="inputState">Town</label>
            <select id="inputState" class="form-control">
              <option selected>Choose...</option>
              <option>...</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class=" col-md-6">
            <button type="submit" class="btn btn-block btn-outline-primary">
              Prev
            </button>
          </div>
          <div class=" col-md-6">
            <button type="submit" class="btn btn-block  btn-primary">
              Next
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="information">
          <div class="information-box border">
            Apartment Title
          </div>
        </div>
      </div>
    </form>
    <div id="j-drop" class=" j-drop">
      <input
        accept="image/*"
        class="upload_input"
        data-msg="Upload  your image"
        type="file"
        name="img"
      />
      <div class=" upload-text">
        <a class="" href="#">
          <img class="" src="/backend/img/upload_icon.png" />
          <b>Click to upload image</b>
        </a>
      </div>
      <div id="j-details" class="j-details">
        <div id="" class="j-complete">
          <div class="j-preview">
            <div id="remove_image" class="remove_image remove-image">
              <a
                class="remove-image"
                data-mode="edit"
                data-randid=""
                data-id=""
                data-url=""
                href="#"
                >Remove</a
              >
            </div>
            <input
              type="hidden"
              class="file_upload_input stored_image_url"
              value=""
              name="image"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      adults: 0,
      children: 0,
      totalPersons: 0,
      showDropDown: true,
      rooms: 1,
    };
  },

  methods: {
    addSubtract(type, as) {
      as === "a" ? this[type]++ : this[type]--;
    },
    dropDownToggle() {
      this.showDropDown = !this.showDropDown;
    },
  },
};
</script>
