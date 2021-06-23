<script>
  import OnboardingHeader from './OnboardingHeader.svelte';
  import { _ } from 'svelte-i18n';

  export let step = null;
  export let sideTitle = null;
  export let title;
  export let subtitle;
</script>

<div
  class="fixed xl:block hidden top-0 left-0 bottom-0 bg-gradient-to-tl
         from-community-300 to-gray-400 xl:w-1/3 content-center"
>
  <div class="h-full py-5 flex flex-col items-center justify-center">
    {#if sideTitle}
      <p class="text-gray-50 mb-10 text:3xl md:text-5xl mt-4 font-bold ">
        {sideTitle}
      </p>
    {/if}
    <slot name="icon" />
    <p class="text-gray-50 text-2xl mt-4 font-bold uppercase">
      {#if step}
        {$_('onboarding.currentStep', {
          values: {
            currentStep: step,
            maxStep: 5,
          },
        })}
      {/if}
    </p>
  </div>
</div>

<section class="md:flex h-full w-full">
  <div class="xl:fixed top-0 right-0 bottom-24 overflow-auto xl:w-2/3 w-full">
    <div class="pl-12 p-5">
      <OnboardingHeader {title} {subtitle} />
    </div>
    <div class="h-2 w-full bg-gray-200" />
    <div class="pt-10">
      <slot name="content" />
    </div>
  </div>
  <div class="md:fixed right-0 bottom-0 xl:w-2/3 w-full h-24 bg-gray-50 px-5">
    <slot name="button" />
  </div>
</section>
