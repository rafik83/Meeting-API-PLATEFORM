<style>
  .preview {
    width: 90vw;
    height: 500px;
    overflow-x: hidden;
  }
</style>

<script>
  export let child;
  export let props;
</script>

<div class="preview">
  <svelte:component this={child} {...props} />
</div>
