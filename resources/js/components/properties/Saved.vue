Guests<template>
  <a
    href="#"
    :data-id="property.id"
    :data-toggle="!$root.loggedIn ? 'modal' : ''"
    :data-target="!$root.loggedIn ? '#loadModal' : ''"
    title="Wishlist"
    class="saved auth-form"
    data-to="login"
    @click.prevent="favorite($event, property.id)"
  >
    <svg
      id="saved-outline"
      :class="[
        !property.is_saved ? '' : 'd-none',
        'is_not_saved_' + property.id,
      ]"
    >
      <use xlink:href="#favorites-outline"></use>
    </svg>
    <svg
      id="saved-none-outline"
      :class="[!property.is_saved ? 'd-none' : '', 'is_saved_' + property.id]"
    >
      <use xlink:href="#favorites"></use>
    </svg>
  </a>
</template>
<script>
import { mapActions } from "vuex";

export default {
  props: {
    property: Object,
  },

  methods: {
    ...mapActions({
      saveProperty: "saveProperty",
    }),
    favorite: function(e, property_id) {
      this.saveProperty({
        property_id: property_id,
      }).then((res) => {});
    },
  },
};
</script>
