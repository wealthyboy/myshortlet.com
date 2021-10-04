<template>
  <div v-if="propertyLoading">
    <div v-for="x in 5" :key="x" class="bg-white mb-2 rounded ap-loaders">
      <div class=" position-relative">
        <div class="row no-gutters">
          <div class="col-md-3 position-relative">
            <div
              class="apart-loading"
              style="width: 100%; height: 232px; background-color: rgb(204, 204, 204);"
            >
              <a href=""></a>
              <div class="fav-icon position-absolute">
                <a
                  href="#"
                  data-id="189"
                  data-toggle="loggedIn"
                  data-target="#auth"
                  title="Wishlist"
                  class="saved"
                ></a>
              </div>
            </div>
          </div>
          <div class="col-md-9 position-relative col-12 pl-3">
            <div class="d-flex  mt-2 justify-content-between">
              <div
                class="apart-loading"
                style="width: 50%; height: 12px; background-color: rgb(204, 204, 204);"
              ></div>
              <div
                class="apart-loading"
                style="width: 40%; height: 12px; background-color: rgb(204, 204, 204);"
              ></div>
            </div>
            <div>
              <small
                ><a
                  class="p-0 d-inline-block apart-loading"
                  style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
                ></a
                >,
                <a
                  href=""
                  class="d-inline-block apart-loading"
                  style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
                ></a
              ></small>
            </div>
            <div class="mb-5">
              <div>
                <span
                  class="d-inline-block apart-loading"
                  style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
                ></span>
                <span
                  class="d-inline-block  apart-loading"
                  style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
                ></span>
                <span
                  class="d-inline-block apart-loading"
                  style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
                ></span>
              </div>
              <div>
                <span
                  class="d-inline-block apart-loading"
                  style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
                ></span>
                <span
                  class="d-inline-block apart-loading"
                  style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
                ></span>
                <span
                  class="d-inline-block apart-loading"
                  style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
                ></span>
              </div>
            </div>
            <div
              class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end"
            >
              <div
                class="apart-loading mb-2"
                style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"
              ></div>
              <div class="d-none d-lg-block d-xl-block text-right mr-2">
                <span
                  class="apart-loading d-inline-block"
                  style="width: 100%; height: 12px; background-color: rgb(204, 204, 204);"
                ></span>
                <div
                  class=" apart-loading btn btn-primary btn-round d-none d-lg-block d-xl-block"
                  style="width: 100%; height: 12px; background-color: rgb(204, 204, 204);"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters({
      propertyLoading: "propertyLoading",
    }),
  },
};
</script>
