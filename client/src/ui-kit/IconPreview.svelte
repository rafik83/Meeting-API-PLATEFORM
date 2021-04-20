<script>
  import * as icons from './icons';

  const iconsWithStrokeNames = [
    'IconDropDown',
    'IconLoader',
    'IconArrowLeft',
    'IconArrowRight',
  ];

  const iconsWitoutStroke = Object.keys(icons).filter(
    (item) => !iconsWithStrokeNames.includes(item)
  );

  const iconsWithStroke = Object.keys(icons).filter((item) =>
    iconsWithStrokeNames.includes(item)
  );
</script>

<section class=" mx-12 my-5">
  <h1 class="text-community-300 text-xl text-bold">Icons</h1>

  <h2 class="mt-5 text-l text-bold">Supports fill property</h2>

  <div class="flex flex-wrap mt-8">
    {#each iconsWitoutStroke as icon}
      <div class="px-5 my-5 w-52 flex flex-col items-center">
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
  </div>

  <h2 class="mt-5 text-l text-bold">Supports stroke property</h2>

  <div class="flex flex-wrap mt-8">
    {#each iconsWithStroke as icon}
      <div class="px-5 my-5 w-52 flex flex-col items-center">
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
</section>
