<script>
  export let community = false;
  export let withBackground = false;
</script>

<h4
  class="md:text-l text-m font-bold my-1 px-4 py-2 {community
    ? 'text-community-300'
    : 'text-gray-500'}"
  class:bg-gray-100={withBackground}
>
  <slot />
</h4>
