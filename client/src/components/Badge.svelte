<style>
  span {
    font-size: 0.6rem;
    padding: 0.1rem 0.5rem;
    border-width: 0.13rem;
  }
</style>

<script>
  export let classList = '';
  export let alert = false;
  export let community = false;

  let color;
  if (alert) {
    color = 'bg-error';
  }

  if (community) {
    color = 'bg-community-300';
  }
</script>

<span
  class="text-gray-50 font-semibold rounded-xl uppercase border border-gray-50 {color} {classList}">
  <slot />
</span>
