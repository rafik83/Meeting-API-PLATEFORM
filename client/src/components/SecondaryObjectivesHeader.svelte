<script>
  import IconTitle from '../ui-kit/icons/IconTitle/IconTitle.svelte';
  import H2 from './H2.svelte';

  export let id;
  export let text;
</script>

<div class="flex">
  <IconTitle fill="#c4cbdc" class="w-5" />
</div>

<div class="flex flex-col w-11/12 mx-3 -mt-4">
  <H2 {id}>{text}</H2>
  <div class="h-0.5 w-full bg-gray-200" />
</div>
