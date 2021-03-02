<style>
  .preview {
    width: 500px;
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
