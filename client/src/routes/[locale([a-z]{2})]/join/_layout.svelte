<script>
  import { errorStore } from '../../../stores/registrationError';
</script>

<div
  class=" p-8 rounded-lg flex flex-col items-center w-full md:w-2/3 lg:w-1/3 md:px-12 m-auto shadow-xl"
>
  {#if $errorStore.hasError}
    <p class="text-error my-5">
      {$errorStore.message}
    </p>
  {/if}

  <section class="md:w-4/5">
    <slot />
  </section>
</div>
