<script>
  export let community = false;
</script>

<h2
  class="md:text-2xl text-xl font-bold my-1 {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h2>
