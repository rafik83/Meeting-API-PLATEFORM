<script>
  import { tns } from '../../node_modules/tiny-slider/src/tiny-slider.js';
  import { onMount } from 'svelte';
  import { v4 as uuidv4 } from 'uuid';

  export let id = 'slider-' + uuidv4();
  export let slidesToDisplay = 4;
  export let autoplay = false;
  export let loop = false;
  export let classList = '';
  export let slider;

  onMount(() => {
    let sliderOptions = {
      container: '#' + id,
      mode: 'carousel',
      controls: true,
      controlsPosition: 'bottom',
      controlsText: false,
      nav: false,
      loop,
      autoplay,
      autoplayButtonOutput: false,
      startIndex: 0,
      center: false,
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
        600: {
          items: 1,
        },
        640: {
          items: 1,
        },
        980: {
          items: slidesToDisplay < 2 ? 1 : 2,
        },
        1380: {
          items: slidesToDisplay < 3 ? 1 : 3,
        },
        1760: {
          items: slidesToDisplay,
        },
      },
    };

    slider = tns(sliderOptions);
  });
</script>

<div class="w-full relative">
  <div {id} class={classList}>
    <slot />
  </div>

  <slot name="prevButton" />
  <slot name="nextButton" />
  <slot name="navInfo" />
</div>
