<script>
  import { sizes } from '../constants';

  export let highlight = false;
  export let dark = true;
  export let size = sizes.SMALL;
  let style;
  let sizeClass;

  if (dark) {
    style = 'text-gray-50 bg-gray-400 whitespace-nowrap';
  }

  if (highlight) {
    style = 'text-gray-50 bg-community-300 whitespace-nowrap';
  }

  if (!dark && !highlight) {
    style = 'text-gray-500 bg-gray-200 truncate';
  }

  if (size === sizes.LARGE) {
    sizeClass = 'text-xl';
  } else {
    sizeClass = 'text-sm';
  }
</script>

<span
  class="inline-block font-semibold rounded-full py-2 px-5 my-2 mr-3 {sizeClass} {style} max-w-full"
>
  <slot />
</span>
