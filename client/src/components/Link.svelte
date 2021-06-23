<script>
  export let to;
</script>

<a
  class="no-underline font-semibold text-gray-50 bg-community-300 rounded-sm p-2 block"
  href={to}
  target="_blank"
>
  <slot />
</a>
