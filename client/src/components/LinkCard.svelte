<script>
  export let kind = 'primary';
  export let id = '';
  export let href = '';

  let style;

  if (kind === 'primary') {
    style = 'text-gray-50 bg-gray-400';
  }

  if (kind === 'community') {
    style = 'text-gray-50 bg-community-300';
  }

  if (kind === 'action') {
    style = 'text-gray-500 bg-gray-150';
  }
</script>

<a
  {id}
  on:click|preventDefault
  {href}
  class="w-auto cursor-pointer text-sm font-semibold rounded-xl h-12 px-4 {style}"
>
  <slot>Button</slot>
</a>
