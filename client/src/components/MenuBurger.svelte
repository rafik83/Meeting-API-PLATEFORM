<script>
  import { IconMenuBurger } from '../ui-kit/icons';
  export let open = false;
  export let stroke = '#2a2e43'
</script>

<div
  class="cursor-pointer"
  on:click
  on:click={() => {
    open = !open;
  }}
>
  <IconMenuBurger width="32" {open} {stroke}/>
</div>
