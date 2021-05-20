<script>
  export let community = false;
  export let withBackground = false;
  export let inlineBlock = false;

  let classList = '';
  if (inlineBlock) {
    classList = 'inline-block';
  }
  if (community) {
    classList += ' text-community-300';
  } else {
    classList += ' text-gray-500';
  }
</script>

<h4
  class="text-m md:text-l font-bold my-1 px-4 py-2 {classList}"
  class:bg-gray-100={withBackground}
>
  <slot />
</h4>
