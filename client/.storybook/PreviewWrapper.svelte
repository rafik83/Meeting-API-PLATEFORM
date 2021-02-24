<style>
  .preview {
    width: 200px;
    height: 600px;
  }
</style>

<script>
  export let child;
  export let props;
</script>

<div class="preview">
  <svelte:component this={child} {...props} />
</div>
