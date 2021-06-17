<script>
  import SlideLabelContainer from './SlideLabelContainer.svelte';
  import Video from './Video.svelte';

  export let video;
  export let label;
  export let videoHeight;

  let videoContainer;
  const handleVideoContainer = (video) => {
    videoContainer = video;
    setTimeout(() => {
      videoHeight = video.offsetHeight;
    }, 100);
  };
</script>

<svelte:window on:resize={() => (videoHeight = videoContainer.offsetHeight)} />

<div class="relative h-full">
  <div class="relative h-full overflow-hidden" use:handleVideoContainer>
    <Video playOnHover={false} sources={video.sources} />
    <div
      class="absolute bottom-0 w-full h-24 bg-gradient-to-t from-gray-50 to-transparent"
    />
  </div>
  <SlideLabelContainer data={label} />
</div>
