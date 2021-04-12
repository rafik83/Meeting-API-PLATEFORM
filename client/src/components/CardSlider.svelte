<script>
  import Slider from './Slider.svelte';
  import MemberCard from './MemberCard.svelte';
  import H2 from './H2.svelte';
  import IconArrowRight from '../ui-kit/icons/IconArrowRight/IconArrowRight.svelte';
  import { v4 as uuidv4 } from 'uuid';

  export let id = 'slider-' + uuidv4();
  export let memberDataForCards = [];
  export let title;
</script>

<div class="w-full mt-10">
  <div class="ml-28 flex items-center">
    <H2>{title}</H2>
    <IconArrowRight width="7" class="ml-3" />
  </div>

  <Slider {id} classList="h-32 my-20" slidesToDisplay="4">
    {#each memberDataForCards as data}
      <div class="w-full flex items-center md:justify-start justify-center">
        <MemberCard {...data} />
      </div>
    {/each}
  </Slider>
</div>
