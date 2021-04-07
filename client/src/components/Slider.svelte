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
  import { v4 as uuidv4 } from 'uuid';

  export let id = 'slider-' + uuidv4();
  export let slidesToDisplay = 4;
  export let classList = '';
  let slider;
  let sliderInfos;
  let isLastCard = false;

  onMount(() => {
    slider = tns({
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
        600: {},
        640: {
          items: 1,
        },
        980: {
          items: 2,
        },
        1380: {
          items: 3,
        },
        1760: {
          items: slidesToDisplay,
        },
      },
    });
  });

  const handleNextClick = () => {
    sliderInfos = slider.getInfo();

    if (
      sliderInfos.displayIndex + sliderInfos.items ===
      sliderInfos.slideCount
    ) {
      isLastCard = true;
    } else {
      isLastCard = false;
    }
  };

  const handlePreviousClick = () => {
    sliderInfos = slider.getInfo();

    if (
      sliderInfos.displayIndex - 2 + sliderInfos.items ===
      sliderInfos.slideCount
    ) {
      isLastCard = true;
    } else {
      isLastCard = false;
    }
  };
</script>

<div class="w-full relative">
  <div
    {id}
    class="{classList} flex justify-start items-center {isLastCard
      ? ''
      : 'md:ml-24'}"
  >
    <slot />
  </div>

  <div
    id="{id}-prev"
    aria-disabled="true"
    class="absolute w-14 h-14 rounded-full bg-gray-50 top-1/2 md:left-16 left-1 pr-1 py-3 cursor-pointer shadow-md flex justify-center items-center"
    on:click={handlePreviousClick}
  >
    <IconArrowLeft />
  </div>

  <div
    id="{id}-next"
    aria-disabled="false"
    class="absolute w-14 h-14 rounded-full bg-gray-50 top-1/2 md:right-16 right-1 pl-1 py-3 cursor-pointer shadow-md flex justify-center items-center"
    on:click={handleNextClick}
  >
    <IconArrowRight />
  </div>
</div>
