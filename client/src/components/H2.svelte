<script>
  export let community = false;
  export let id = null;
</script>

<h2
  {id}
  class="text-xl md:text-2xl font-bold my-1 mr-5 inline-block {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h2>
