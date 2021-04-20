<script>
  export let highlight = false;
  let style;

  if (highlight) {
    style = 'text-gray-50 bg-community-300 whitespace-nowrap';
  } else {
    style = 'text-gray-500 bg-gray-200 truncate';
  }
</script>

<span
  class="inline-block text-sm font-semibold rounded-full py-2 px-5 my-2 mr-3 {style} max-w-full">
  <slot />
</span>
