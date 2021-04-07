<script>
  export let community = false;
</script>

<h2
  class="md:text-xl text-2xl font-bold my-1 inline-block {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h2>
