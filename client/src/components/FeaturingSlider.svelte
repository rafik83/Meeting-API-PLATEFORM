<style>
  #nav-info {
    top: calc(var(--video-height) - 120px);
  }
  @media screen and (max-width: 1280px) {
    #nav-info {
      top: calc(var(--video-height) - 70px);
    }
  }
</style>

<script>
  import Slider from './Slider.svelte';
  import { v4 as uuidv4 } from 'uuid';
  import IconArrowRightLight from '../ui-kit/icons/IconArrowRightLight/IconArrowRightLight.svelte';
  import IconArrowLeftLight from '../ui-kit/icons/IconArrowLeftLight/IconArrowLeftLight.svelte';
  import { onMount } from 'svelte';
  import FeaturingSliderNav from './FeaturingSliderNav.svelte';
  import VideoSlide from './VideoSlide.svelte';

  export let id = `slider-${uuidv4()}`;
  export let slides = [];
  let videoHeight;

  let slider;
  let currentIndex = 0;
  onMount(() => {
    slider.events.on('indexChanged', (info) => {
      currentIndex = info.index - 1;
    });
  });
</script>

<section class="relative overflow-hidden">
  <Slider
    {id}
    slidesToDisplay={1}
    classList="flex items-center justify-center w-full h-full z-10"
    loop
    bind:slider
  >
    {#each slides as slide}
      <VideoSlide {...slide} bind:videoHeight />
    {/each}
    <button
      type="button"
      slot="nextButton"
      id={`${id}-next`}
      class="navButton absolute w-14 py-4 px-5 right-10 transform -translate-y-1/2"
      style={`top:${videoHeight / 2}px`}
    >
      <IconArrowRightLight width="100%" />
    </button>
    <button
      type="button"
      slot="prevButton"
      id={`${id}-prev`}
      class="navButton absolute w-14 py-4 px-5 left-10 transform -translate-y-1/2"
      style={`top:${videoHeight / 2}px`}
    >
      <IconArrowLeftLight width="100%" />
    </button>
    <div
      slot="navInfo"
      id="slider-navigation-info"
      class="videoNav absolute right-1/2 transform translate-x-1/2 z-20"
      style={`--video-height: ${videoHeight}px`}
    >
      <FeaturingSliderNav {currentIndex} numberOfSlides={slides.length} />
    </div>
  </Slider>
</section>
