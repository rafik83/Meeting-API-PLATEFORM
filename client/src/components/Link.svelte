<script>
  import { stores } from '@sapper/app';
  const { session } = stores();
  export let to;
</script>

<a href={`${$session.locale}/${to}`}>
  <slot />
</a>
