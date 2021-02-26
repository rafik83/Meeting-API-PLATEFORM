<script>
  import { createEventDispatcher } from 'svelte';
  import PriorityItem from './PriorityItem.svelte';

  export let name;
  export let priority = null;
  export let id;
  export let displayPriority = true;
  const dispatch = createEventDispatcher();

  const handleOnClick = () => {
    dispatch('click', {
      priority,
      name,
      id,
    });
  };
</script>

<div class="flex w-10/12 relative justify-center px-7 items-center mb-6">
  {#if priority && displayPriority}
    <PriorityItem {priority} />
  {/if}

  <button
    class="px-7 py-5 shadow-full w-full font-semibold uppercase rounded-full {priority
      ? 'bg-community-300 text-gray-50'
      : ''}"
    on:click={handleOnClick}>{name}</button
  >
</div>
