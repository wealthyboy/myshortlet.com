<template>
  <span class="dropdown" :class="{ 'is-active': open }">
    <div class="dropdown-trigger">
      <button
        class="button"
        aria-haspopup="true"
        aria-controls="dropdown-menu"
        @click.prevent="toggle"
      >
        <span>Dropdown button</span>
        <span class="icon is-small">
          <i class="fas fa-angle-down" aria-hidden="true"></i>
        </span>
      </button>
    </div>
    <div class="dropdown-menu">
      <div class="dropdown-content">
        <a href="#" class="dropdown-item">Hello</a>
      </div>
    </div>
  </span>
</template>

<script>
export default {
  data() {
    return {
      open: false,
    };
  },

  created() {
    window.addEventListener("click", this.close);
  },

  beforeDestroy() {
    window.removeEventListener("click", this.close);
  },

  methods: {
    toggle() {
      this.open = !this.open;
    },

    close(e) {
      if (!this.$el.contains(e.target)) {
        this.open = false;
      }
    },
  },
};
</script>
