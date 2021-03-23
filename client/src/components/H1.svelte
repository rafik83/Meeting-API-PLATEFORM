<script>
  export let community = false;
</script>

<h1
  class="md:text-5xl text-4xl font-bold my-1 {community
    ? 'text-community-300'
    : 'text-gray-500'}"
>
  <slot />
</h1>
