<script>
  import IconArrowRight from '../ui-kit/icons/IconArrowRight/IconArrowRight.svelte';
  import { sizes } from '../constants';

  export let type = 'button';
  export let kind = 'primary';
  export let withMargin = false;
  export let arrow = false;
  export let size = sizes.MEDIUM;
  export let fullWidth = true;
  export let id = null;

  let style;
  let arrowStyle;

  if (kind === 'primary') {
    style = 'text-gray-50 bg-gray-400';
    arrowStyle = 'text-gray-50';
  }

  if (kind === 'secondary') {
    style = 'text-gray-400 bg-gray-50';
    arrowStyle = 'text-gray-400';
  }

  if (kind === 'tiertiary') {
    style = 'text-community-300 bg-gray-50';
    arrowStyle = 'text-community-300';
  }

  if (kind === 'community') {
    style = 'text-gray-50 bg-community-300';
    arrowStyle = 'text-gray-50';
  }

  if (kind === 'simple') {
    style = 'text-gray-500 bg-gray-200';
    arrowStyle = 'text-gray-500';
  }

  if (kind === 'ghost') {
    style = 'text-gray-500 bg-gray-100';
    arrowStyle = 'text-gray-500';
  }

  if (kind === 'action') {
    style = 'text-gray-500 bg-gray-150';
    arrowStyle = 'text-gray-500';
  }

  if (kind === 'outlined') {
    style = 'border-2 border-gray-400 text-gray-500 bg-gray-50';
    arrowStyle = 'text-gray-400';
  }

  if (fullWidth) {
    style += ' w-full';
  }

  if (size === sizes.SMALL) {
    style += ' h-9';
  }

  if (size === sizes.MEDIUM) {
    style += ' h-12';
  }
</script>

<button
  on:click|preventDefault
  {type}
  class="text-sm font-semibold my-5 px-3 rounded-lg {style}"
  class:mx-5={withMargin}
  {id}
>
  {#if arrow}
    <div class="flex justify-center items-center mx-2">
      <slot />
      <IconArrowRight class="stroke-current ml-2 {arrowStyle}" width="6" />
    </div>
  {:else}
    <slot />
  {/if}
</button>
