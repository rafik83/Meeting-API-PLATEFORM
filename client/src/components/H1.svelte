<script>
  export let community = false;
</script>

<h1
  class="md:text-4xl text-5xl font-bold my-1 {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h1>
