<script>
  import RegistrationPipeLineHeader from './RegistrationPipeLineHeader.svelte';
  import { _ } from 'svelte-i18n';

  export let user;
  export let step;
</script>

<div
  class="fixed xl:block hidden top-0 left-0 bottom-0 bg-gradient-to-tl
         from-community-300 to-gray-400 xl:w-1/3 content-center"
>
  <div class="h-full py-5 flex flex-col items-center justify-center">
    <slot name="icon" />
    <p class="text-gray-50 text-2xl mt-4 font-bold uppercase">Step {step}/5</p>
  </div>
</div>

<section class="flex h-full w-full">
  <div class="xl:fixed top-0 right-0 bottom-24 overflow-auto xl:w-2/3 w-full">
    <div class="pl-10 p-5">
      <RegistrationPipeLineHeader
        title="{$_('registration.hello')}."
        subtitle="{user.firstName} {user.lastName}"
      />
    </div>
    <div class="h-2 w-full bg-gray-200" />
    <div class="md:pl-16 pt-10 p-5">
      <slot name="content" />
    </div>
  </div>
  <div class="fixed right-0 bottom-0 xl:w-2/3 w-full h-24 bg-gray-50 px-5">
    <slot name="button" />
  </div>
</section>
