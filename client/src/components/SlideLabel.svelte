<style>
  .labelTransition {
    transition: 0.8s ease;
  }
</style>

<script>
  import IconArrowLeft from '../ui-kit/icons/IconArrowLeft/IconArrowLeft.svelte';

  let width = '';
  let labelElement;
  const computeElement = (element) => {
    labelElement = element;
    element.style.height = `${element.offsetHeight}px`;
    element.style.width = width = `${element.offsetWidth}px`;
  };

  const fixWidth = (element) => {
    element.style.width = `${element.offsetWidth}px`;
  };

  let openLabel = true;
  const handleClick = () => {
    openLabel = !openLabel;

    if (openLabel) {
      labelElement.style.width = width;
    } else {
      labelElement.style.width = '0px';
    }
  };
</script>

<div class="bg-gray-400 relative">
  <div
    class="labelTransition overflow-hidden pr-7 py-5 {openLabel ? 'pl-16' : ''}"
  >
    <div use:computeElement class="labelTransition">
      <div
        use:fixWidth
        class="labelTransition {openLabel ? '' : 'transform -translate-x-full'}"
      >
        <slot />
      </div>
    </div>
  </div>
  <button on:click={handleClick}
    ><div
      class="labelTransition absolute transform -translate-y-1/2 top-1/2 -right-3 h-7 w-7 p-1.5 bg-gray-50 rounded-full flex items-center justify-center {openLabel
        ? ''
        : 'rotate-180'}"
    >
      <IconArrowLeft width="100%" height="100%" />
    </div>
  </button>
</div>
