<script>
  import { toMemberPage } from '../modules/routing';

  export let isOnline = null;
  export let firstName;
  export let lastName;
  export let id;
</script>

<div class="relative">
  <a href={toMemberPage(id)}
    ><div
      class="rounded-full flex  justify-center font-black items-center text-gray-50  bg-community-100 text-3xl w-32 h-32"
    >
      {`${firstName[0].toUpperCase()}${lastName[0].toUpperCase()}`}
    </div>
    {#if isOnline !== null}
      <div
        class="absolute w-3.5 h-3.5 rounded-xl border-2 border-gray-50 right-5 bottom-0 {isOnline
          ? 'bg-success'
          : 'bg-error'}"
      />
    {/if}
  </a>
</div>
