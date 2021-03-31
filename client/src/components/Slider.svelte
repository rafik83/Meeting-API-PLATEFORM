<style>
  [aria-disabled='true'] {
    display: none;
  }

  [aria-disabled='false'] {
    display: flex;
  }
</style>

<script>
  import { tns } from '../../node_modules/tiny-slider/src/tiny-slider.js';
  import { onMount } from 'svelte';
  import IconArrowLeft from '../ui-kit/icons/IconArrowLeft/index.js';
  import IconArrowRight from '../ui-kit/icons/IconArrowRight/index.js';

  export let id = 'slider';
  export let slideMargin = 0;
  export let slidesToDisplay = 5;

  onMount(() => {
    tns({
      container: '#' + id,
      mode: 'carousel',
      controls: true,
      controlsPosition: 'bottom',
      controlsText: false,
      loop: false,
      autoplay: false,
      startIndex: 0,
      center: false,
      nav: false,
      mouseDrag: true,
      touch: true,
      nextButton: '#' + id + '-next',
      prevButton: '#' + id + '-prev',
      controlsContainer: false,
      slideCount: false,
      slideCountNew: false,
      onInit: () => {
        document.querySelector('.tns-liveregion.tns-visually-hidden').remove();
      },
      responsive: {
        640: {
          edgePadding: 0,
          items: 1,
          gutter: 0,
        },
        1200: {
          edgePadding: 100,
          items: slidesToDisplay,
          gutter: slideMargin,
        },
      },
    });
  });
</script>

<div class="w-full relative">
  <div {id} class="flex justify-start items-start">
    <slot />
  </div>

  <div
    id="{id}-prev"
    aria-disabled="true"
    class="absolute w-14 h-14 rounded-full bg-gray-50 top-1/2 left-16 pr-1 py-3 cursor-pointer shadow-md flex justify-center items-center"
  >
    <IconArrowLeft />
  </div>

  <div
    id="{id}-next"
    aria-disabled="false"
    class="absolute w-14 h-14 rounded-full bg-gray-50 top-1/2 right-16 pl-1 py-3 cursor-pointer shadow-md flex justify-center items-center"
  >
    <IconArrowRight />
  </div>
</div>
