<script>
  import IconLinkedin from './IconLinkedin.svelte';
  import IconVimeet from './IconVimeet.svelte';

  export let type = '';
  export let classSSO = '';
  export let url = '';
</script>

{#if type === 'linkedin'}
  <a
    href={url}
    class="w-auto font-semibold rounded-lg h-8 items-center justify-center flex my-2.5 text-gray-50 mr-2 {classSSO}">
    <div class="flex flex-column">
      <IconLinkedin />
    </div>
  </a>
{/if}

{#if type === 'vimeet'}
  <a
    href={url}
    class="w-auto font-semibold rounded-lg h-8 items-center justify-center flex my-2.5 text-gray-50 mr-2 {classSSO}">
    <div class="flex flex-column">
      <IconVimeet />
    </div>
  </a>
{/if}
