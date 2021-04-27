<script>
  export let community = false;
</script>

<h3
  class="text-l md:text-xl font-bold my-1 {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h3>
