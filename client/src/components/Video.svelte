<style>
  video {
    max-height: 45rem;
  }
</style>

<script>
  import IconPlay from '../ui-kit/icons/IconPlay/IconPlay.svelte';

  export let sources = [];
  export let playOnHover = true;

  let video;
  const handleVideo = (videoElement) => {
    video = videoElement;
  };

  let isPlaying = false;
  const handleClick = () => {
    isPlaying = !isPlaying;

    if (isPlaying) {
      video.play();
    } else {
      video.pause();
    }
  };

  const handleMouseEnter = () => {
    if (playOnHover) {
      isPlaying = true;
      video.play();
    }
  };

  const handleMouseLeave = () => {
    if (playOnHover) {
      isPlaying = false;
      video.pause();
    }
  };
</script>

<div
  on:click={handleClick}
  on:mouseenter={handleMouseEnter}
  on:mouseleave={handleMouseLeave}
  class="relative"
>
  <video width="100%" class="object-cover overflow-hidden" use:handleVideo>
    {#each sources as { source, type }}
      <source src={source} {type} />
    {/each}
    <track kind="captions" />
  </video>

  <div
    class="absolute transform -translate-y-1/2 translate-x-1/2 top-1/2 right-1/2 w-24 h-24 cursor-pointer {isPlaying
      ? 'hidden'
      : 'block'}"
  >
    <IconPlay width="100%" />
  </div>
</div>
