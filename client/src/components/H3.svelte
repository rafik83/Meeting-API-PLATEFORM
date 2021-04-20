<script>
  export let community = false;
</script>

<h3
  class="md:text-l text-xl font-bold my-1 pl-12 {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h3>
