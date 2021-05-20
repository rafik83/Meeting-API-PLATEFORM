<script>
  import SlideLabel from './SlideLabel.svelte';
  import Button from './Button.svelte';
  import H2 from './H2.svelte';
  import { sizes } from '../constants';

  export let data = {};
</script>

<div
  class="absolute invisible opacity-0 xl:opacity-100 xl:visible bottom-20 z-50"
>
  <SlideLabel>
    <div class="text-gray-50 whitespace-nowrap">
      <H2>{data.title}</H2>
      <p>{data.text}</p>
    </div>
    <a href={data.link} class="w-28 block">
      <Button kind="tiertiary" arrow size={sizes.SMALL}>
        {data.textButton}
      </Button>
    </a>
  </SlideLabel>
</div>

<div class="block xl:hidden w-full px-5 pt-3 bg-gray-400">
  <div class="text-gray-50">
    <H2>{data.title}</H2>
    <p>{data.text}</p>
  </div>
  <a href={data.link} class="w-28 block">
    <Button kind="tiertiary" arrow size={sizes.SMALL}>
      {data.textButton}
    </Button>
  </a>
</div>
