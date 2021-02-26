<script>
  export let type;
  export let kind = 'primary';
  let style;

  if (kind === 'primary') {
    style = 'text-gray-50 bg-gray-400';
  }

  if (kind === 'secondary') {
    style = 'text-gray-400 bg-gray-50';
  }

  if (kind === 'tiertiary') {
    style = 'text-community-300 bg-gray-50';
  }

  if (kind === 'community') {
    style = 'text-gray-50 bg-community-300';
  }

  if (kind === 'ghost') {
    style = 'text-gray-500 bg-gray-100';
  }

  if (kind === 'outlined') {
    style = 'border-2 border-gray-400 text-gray-500 bg-gray-50';
  }
</script>

<button
  on:click|preventDefault
  type={type || ''}
  class="w-full text-sm font-semibold my-5 rounded-lg h-12 {style}">
  <slot>Button</slot>
</button>
