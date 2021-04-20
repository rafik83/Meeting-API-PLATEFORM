<script>
  export let priority;
  export let sticky = false;
</script>

<div
  class="rounded-full flex absolute items-center justify-center text-success border-solid border w-6 h-6 left-0 {sticky
    ? 'left-4 bg-gray-50 border-community-300'
    : 'border-success'}"
>
  <span class="font-bold">
    {priority}
  </span>
</div>
