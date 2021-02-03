<script>
  export let href;
  export let label;
  export let content;
</script>

<p class="text-base text-community-300 font-semibold text-center mt-5">
  {label}
</p>
<a
  {href}
  class="w-full flex justify-center mt-1 items-center font-semibold rounded-lg bg-community-300 h-12 text-gray-50">
  {content}
</a>
