<script>
  export let content;
  export let type;
</script>

<button
  on:click|preventDefault
  type={type || ''}
  class="w-4/5 text-sm text-gray-50 font-semibold my-5 rounded-lg h-12 bg-gray-400">
  {content}
</button>
