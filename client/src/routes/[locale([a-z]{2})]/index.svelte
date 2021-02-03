<script context="module">
  export async function preload(page, session) {
    return { user: session.user };
  }
</script>

<script>
  import { toLoginPage } from '../../modules/routing';

  export let user;
</script>

<h1>Home Page</h1>
{#if user}
  <p>Vous êtes connecté</p>
{:else}
  <p>Vous êtes pas connecté</p>
  <a href={toLoginPage()}> Go to login form </a>
{/if}
