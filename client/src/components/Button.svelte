<script>
  export let content;
  export let type;
</script>

<button
  on:click|preventDefault
  type={type || ''}
  class="w-full text-sm text-gray-50 font-semibold my-5 rounded-lg h-12 bg-gray-400">
  {content}
</button>
