<style>
  button:disabled {
    display: none;
  }
</style>

<script>
  import Slider from './Slider.svelte';
  import MemberCard from './MemberCard.svelte';
  import H2 from './H2.svelte';
  import IconArrowRight from '../ui-kit/icons/IconArrowRight/IconArrowRight.svelte';
  import IconArrowLeft from '../ui-kit/icons/IconArrowLeft/IconArrowLeft.svelte';
  import { v4 as uuidv4 } from 'uuid';
  import { CARD_KIND } from '../constants';
  import CompanyCard from './CompanyCard.svelte';

  export let id = 'slider-' + uuidv4();
  export let cards = [];
  export let title;
  let slider;
  let sliderInfos;

  let isLastCard = false;
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

  const buttonStyle =
    'absolute w-14 h-14 top-1/2 transform -translate-y-1/2 pr-1 py-3 cursor-pointer flex justify-center items-center rounded-full bg-gray-50 shadow-md';
</script>

<div class="w-full mt-10">
  <div class="md:ml-28 ml-5 flex items-center">
    <H2>{title}</H2>
    <IconArrowRight width="7" class="ml-3" />
  </div>

  <Slider
    {id}
    classList="flex justify-start items-center h-32 my-20 {isLastCard
      ? ''
      : 'md:ml-24'}"
    slidesToDisplay="4"
    bind:slider
  >
    {#each cards as card}
      {#if card.kind == CARD_KIND.member}
        <div class="w-full flex items-center md:justify-start justify-center">
          <MemberCard on:meet_member on:view_member_profile {...card} />
        </div>
      {:else}
        <div class="w-full flex items-center md:justify-start justify-center">
          <CompanyCard on:generate_new_leads {...card} />
        </div>
      {/if}
    {/each}

    <button
      type="button"
      slot="prevButton"
      class={`${buttonStyle} md:left-16 left-1`}
      on:click={handlePreviousClick}
      id={`${id}-prev`}
    >
      <IconArrowLeft width="13" />
    </button>
    <button
      type="button"
      slot="nextButton"
      class={`${buttonStyle} md:right-16 right-1`}
      on:click={handleNextClick}
      id={`${id}-next`}
    >
      <IconArrowRight width="13" />
    </button>
  </Slider>
</div>
