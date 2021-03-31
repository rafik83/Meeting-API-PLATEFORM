<style>
  .preview {
    width: 90vw;
    height: 500px;
  }
</style>

<script>
  export let child;
  export let props;
</script>

<div class="preview">
  <svelte:component this={child} {...props} />
</div>
