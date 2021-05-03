<script>
  import IconFlecheLogo from '../ui-kit/icons/IconFlecheLogo/IconFlecheLogo.svelte';
  import IconVimeet365 from '../ui-kit/icons/IconVimeet365/IconVimeet365.svelte';

  export let communityName = '';
</script>

<div class="flex h-12 pt-1.5">
  <IconVimeet365 width="40" />
  <div class="relative ml-2">
    <div
      class="absolute h-full pl-5 pr-3 bg-community-300 whitespace-nowrap text-xl text-gray-50 uppercase font-black flex items-center"
    >
      {communityName}
    </div>
    <div class="absolute left-0">
      <IconFlecheLogo width="8" />
    </div>
  </div>
</div>
