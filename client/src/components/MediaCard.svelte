<style global lang="postcss">
  .media-card-description h4 {
    @apply text-community-300 font-bold m-0;
  }

  .media-card-description p {
    @apply m-0;
  }

  .badge {
    @apply absolute z-10 bg-gray-400 text-gray-50 text-xs px-2 pt-0.5 font-bold uppercase;
  }
</style>

<script>
  import LinkCard from './LinkCard.svelte';
  import IconMore from '../ui-kit/icons/IconMore/IconMore.svelte';
  import Video from './Video.svelte';

  export let video;
  export let name;
  export let description;
  export let ctaLabel;
  export let ctaUrl;
  export let mediaType;

  let expand = false;
</script>

<div
  on:mouseenter={() => (expand = true)}
  on:mouseleave={() => (expand = false)}
  class="w-96 bg-gray-50 shadow-full"
>
  <span class="badge">{mediaType}</span>
  <div class="h-56">
    <Video controls sources={[{ source: video, type: 'video/mp4' }]} />
  </div>

  {#if expand}
    <div class=" w-full py-2 px-4">
      <div class="flex justify-end">
        <LinkCard href={ctaUrl} kind="action">
          <div class="flex items-center h-full">
            <span class="pr-4">{ctaLabel}</span>
            <IconMore />
          </div>
        </LinkCard>
      </div>
      <p class="font-semibold w-2/3 my-4 overflow-auto">{name}</p>

      <div class="media-card-description">
        {@html description}
      </div>
    </div>
  {/if}
</div>
