<style>
  .preview {
    width: 400px;
    height: 400px;
  }
</style>

<script>
  export let child;
  export let props;
</script>

<div class="preview">
  <svelte:component this={child} {...props} />
</div>
