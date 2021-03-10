<script>
  import * as icons from './icons';

  const iconsWithStrokeNames = ['IconDropDown', 'IconLoader'];

  const iconsWitoutStroke = Object.keys(icons).filter(
    (item) => !iconsWithStrokeNames.includes(item)
  );

  const iconsWithStroke = Object.keys(icons).filter((item) =>
    iconsWithStrokeNames.includes(item)
  );
</script>

<div class="flex flex-wrap">
  {#each iconsWitoutStroke as icon}
    <div class="w-1/12 mx-12 my-5 flex flex-col items-center">
      <svelte:component
        this={icons[icon]}
        title={icon}
        height={22}
        width={45}
        fill={'#000000'}
      />
      {icon}
    </div>
  {/each}

  {#each iconsWithStroke as icon}
    <div class="w-1/12 mx-12 my-5 flex flex-col items-center">
      <svelte:component
        this={icons[icon]}
        title={icon}
        height={22}
        width={45}
        stroke={'#000000'}
      />
      {icon}
    </div>
  {/each}
</div>
