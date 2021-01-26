<style>
</style>

<script context="module">
  import { apiRoutes } from '../../../modules/routing';
  export async function preload() {
    try {
      const res = await this.fetch(apiRoutes.COMMUNITIES, {
        headers: {
          accept: 'application/json',
        },
      });
      const communities = await res.json();
      return { communities };
    } catch (error) {
      console.log(error);
    }
  }
</script>

<script>
  import { getTranslator } from '../../../modules/i18n';
  const _ = getTranslator();
  export let communities;
</script>

<h1>{$_('comunities.title')}</h1>
<h2>voici les communautés</h2>
{#each communities as { id, name }}
  <p>Communauté n°{id} : {name}</p>
{/each}
