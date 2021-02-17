<script>
  export let title;
  export let subtitle = null;

  const subtitleLayout = 'md:text-2xl text-xl font-bold text-community-300';
  const titleLayout = 'md:text-5xl text-4xl font-bold my-0 text-gray-500';
</script>

<header>
  <h1 class={subtitle ? titleLayout : subtitleLayout}>
    {title}
  </h1>

  {#if subtitle}
    <h2 class={subtitleLayout}>
      {subtitle}
    </h2>
  {/if}
</header>
