<script>
  export let community = false;
</script>

<h1
  class="text-4xl md:text-5xl font-bold my-1 {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h1>
