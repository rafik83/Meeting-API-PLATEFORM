<style>
  a {
    cursor: pointer;
    text-decoration: none;
    padding: 1em 0.5em;
    display: block;
  }
</style>

<script>
  import { stores } from '@sapper/app';
  const { session } = stores();
  export let to;
</script>

<a href={`${$session.locale}/${to}`}>
  <slot />
</a>
