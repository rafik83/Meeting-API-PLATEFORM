<script>
  import { createEventDispatcher } from 'svelte';
  import PriorityItem from './PriorityItem.svelte';

  export let name;
  export let priority = null;
  export let id;
  export let displayPriority = true;
  export let sticky = false;
  const stickyStyle = sticky ? 'py-2 px-5' : 'py-5 px-7';
  const dispatch = createEventDispatcher();

  const handleOnClick = () => {
    dispatch('click', {
      priority,
      name,
      id,
    });
  };
</script>

<div
  class:w-full={!sticky}
  class="flex relative justify-center px-7 items-center mb-6"
>
  {#if priority && displayPriority}
    <PriorityItem {priority} {sticky} />
  {/if}

  <button
    class="shadow-full w-full font-semibold uppercase rounded-full {stickyStyle} {priority
      ? 'bg-community-300 text-gray-50'
      : ''}"
    on:click={handleOnClick}>{name}</button
  >
</div>
