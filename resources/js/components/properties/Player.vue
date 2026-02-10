<template>
  <video
    ref="videoPlayer"
    controls
    autoplay
    muted
    style="width: 100%; max-width: 800px;"
  ></video>
</template>

<script>
import Hls from "hls.js";

export default {
  props: {
    src: {
      type: String,
      required: true, // pass the master.m3u8 URL
    },
  },
  mounted() {
    const video = this.$refs.videoPlayer;

    if (Hls.isSupported()) {
      const hls = new Hls();
      hls.loadSource(this.src);
      hls.attachMedia(video);
      hls.on(Hls.Events.MANIFEST_PARSED, () => video.play());
    } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
      video.src = this.src;
      video.addEventListener("loadedmetadata", () => video.play());
    }
  },
};
</script>
