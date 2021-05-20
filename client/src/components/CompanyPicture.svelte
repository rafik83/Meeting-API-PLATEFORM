<script>
  export let source;
  export let name = 'Company';
  export let companyWebsite = '';
</script>

{#if companyWebsite}
  <div class="w-20 h-20 rounded-full overflow-hidden mb-3">
    <a href={companyWebsite} target="_blank">
      <img src={source} alt={`${name} logo`} class="object-cover" />
    </a>
  </div>
{:else}
  <div class="w-20 h-20 rounded-full overflow-hidden mb-3">
    <img src={source} alt={`${name} logo`} />
  </div>
{/if}
