<template>
  <div>
    <section class="bg-single-image-03 pt-9 step-one" data-animated-id="5">
      <div class="container">
        <h2 class="text-dark text-center mxw-751 px-md-8 lh-163">
          We have the most listings and constant updates. So you’ll never miss
          out.
        </h2>
        <span class="heading-divider mx-auto"></span>
        <div class="row mt-7 mb-6 mb-lg-11">
          <div class="col-lg-6 mb-6 mb-lg-0">
            <div
              class="media rounded-lg bg-white border border-hover shadow-xs-2 shadow-hover-lg-1 px-7 py-8 hover-change-image flex-column flex-sm-row h-100 fadeInUp animated"
              data-animate="fadeInUp">
              <img src="/img/group-16.png" alt="Buy a new home" class="mb-6 mb-sm-0 mr-sm-6" />
              <div class="media-body">
                <a href="#" class="text-decoration-none d-flex align-items-center">
                  <h4 class="fs-20 lh-1625 text-secondary mb-1">
                    Single Apartment
                  </h4>
                  <div class="position-relative d-flex align-items-center ml-2">
                    <span class="image text-primary position-absolute pos-fixed-left-center fs-16"><i
                        class="fal fa-long-arrow-right"></i></span>
                    <span class="text-primary fs-42 lh-1 hover-image d-flex align-items-center"><svg
                        class="icon icon-long-arrow">
                        <use xlink:href="#icon-long-arrow"></use>
                      </svg></span>
                  </div>
                </a>
                <p class="mb-0">
                  Click here if you
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-6 mb-lg-0">
            <div
              class="media rounded-lg bg-white border border-hover shadow-xs-2 shadow-hover-lg-1 px-7 py-8 hover-change-image flex-column flex-sm-row h-100 fadeInUp animated"
              data-animate="fadeInUp">
              <img src="/img/group-17.png" alt="Sell a home" class="mb-6 mb-sm-0 mr-sm-6" />
              <div class="media-body">
                <a href="#" class="text-decoration-none d-flex align-items-center">
                  <h4 class="fs-20 lh-1625 text-secondary mb-1">
                    Multiple Apartments
                  </h4>
                  <div class="position-relative d-flex align-items-center ml-2">
                    <span class="image text-primary position-absolute pos-fixed-left-center fs-16"><i
                        class="fal fa-long-arrow-right"></i></span>
                    <span class="text-primary fs-42 lh-1 hover-image d-flex align-items-center"><svg
                        class="icon icon-long-arrow">
                        <use xlink:href="#icon-long-arrow"></use>
                      </svg></span>
                  </div>
                </a>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
          <div class="col-md-12 text-right mt-5">
            <a href="" class="btn btn-lg text-secondary btn-accent">Next
              <i class="far fa-long-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section>
      <h2>Title</h2>
      <form action="" class="form-row">
        <div class="col-md-7">
          <div class="form-group">
            <label for="">Title hhh</label>
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
        </div>
        <div class="col-md-5">
          <div id="j-drop" class=" j-drop">
            <input accept="image/*" class="upload_input" data-msg="Upload  your image" type="file" name="img" />
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
                    <a class="remove-image" data-mode="edit" data-randid="" data-id="" data-url="" href="#">Remove</a>
                  </div>
                  <input type="hidden" class="file_upload_input stored_image_url" value="" name="image" />
                </div>
              </div>
            </div>
          </div>
          <div class="information">
            <div class="information-box border"></div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-row">
            <div class=" col-md-6">
              <a href="" class="btn btn-lg text-secondary btn-accent">
                <i class="far fa-long-arrow-left ml-1"></i>

                Prev
              </a>
            </div>
            <div class=" col-md-6 text-right">
              <button type="submit" class="btn btn-lg text-secondary btn-accent">
                Next
                <i class="far fa-long-arrow-right ml-1"></i>
              </button>
            </div>
          </div>
        </div>
      </form>
    </section>

    <section>
      <h2>Common Facilities</h2>

      <div class="row">
        <div class="col-sm-6 col-lg-3">
          <ul class="list-group list-group-no-border">
            <li class="list-group-item px-0 pt-0 pb-2">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="features[]" id="attic" />
                <label class="custom-control-label" for="attic">Attic</label>
              </div>
            </li>
            <li class="list-group-item px-0 pt-0 pb-2">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="features[]" id="basketball-court" />
                <label class="custom-control-label" for="basketball-court">Basketball court</label>
              </div>
            </li>
          </ul>
        </div>

        <div class="col-md-12">
          <div class="form-row">
            <div class=" col-md-6">
              <a href="" class="btn btn-lg text-secondary btn-accent">
                <i class="far fa-long-arrow-left ml-1"></i>

                Prev
              </a>
            </div>
            <div class=" col-md-6 text-right">
              <button type="submit" class="btn btn-lg text-secondary btn-accent">
                Next
                <i class="far fa-long-arrow-right ml-1"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <form action="">
      <section>
        <h2>Title</h2>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label for="">Title hhh</label>
              <input type="email" class="form-control" id="" placeholder="" />
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="inputState">Bedrooms</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="inputState">Adults</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="inputState">Children</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="">Price</label>
              <input type="email" class="form-control" id="" placeholder="" />
            </div>
          </div>

          <div class="col-md-12">
            <h4>Bedroom</h4>
            <div class="d-flex flex-grow-1">
              <div class="custom-control custom-radio mr-3">
                <input type="radio" class="custom-control-input" id="customControlValidation2" name="radio-stacked"
                  required />
                <label class="custom-control-label" for="customControlValidation2">1 queen bed</label>
              </div>
              <div class="custom-control custom-radio mb-3">
                <input type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked"
                  required />
                <label class="custom-control-label" for="customControlValidation3">1 double bed</label>
                <div class="invalid-feedback">
                  More example invalid feedback text
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div id="j-drop" class=" j-drop">
              <input accept="image/*" class="upload_input" data-msg="Upload  your image" type="file" name="img" />
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
                      <a class="remove-image" data-mode="edit" data-randid="" data-id="" data-url="" href="#">Remove</a>
                    </div>
                    <input type="hidden" class="file_upload_input stored_image_url" value="" name="image" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h2>Title</h2>

        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <ul class="list-group list-group-no-border">
              <li class="list-group-item px-0 pt-0 pb-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="features[]" id="attic" />
                  <label class="custom-control-label" for="attic">Attic</label>
                </div>
              </li>
              <li class="list-group-item px-0 pt-0 pb-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="features[]" id="basketball-court" />
                  <label class="custom-control-label" for="basketball-court">Basketball court</label>
                </div>
              </li>
            </ul>
          </div>
        </div>

        <div class="form-row">
          <div class=" col-md-6">
            <a href="" class="btn btn-lg text-secondary btn-accent">
              <i class="far fa-long-arrow-left ml-1"></i>

              Prev
            </a>
          </div>
          <div class=" col-md-6 text-right">
            <button type="submit" class="btn btn-lg text-secondary btn-accent">
              Next
              <i class="far fa-long-arrow-right ml-1"></i>
            </button>
          </div>
        </div>
      </section>
    </form>
  </div>
</template>
<script>
import Persons from "../persons/Persons.vue";
export default {
  components: { Persons },
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
