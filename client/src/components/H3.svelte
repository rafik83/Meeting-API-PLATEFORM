<script>
  export let community = false;
</script>

<h3
  class="md:text-xl text-l font-bold my-1 {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h3>
