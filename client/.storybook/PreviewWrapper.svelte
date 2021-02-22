<style>
  .preview {
    width: 900px;
    height: 900px;
  }
</style>

<script>
  export let child;
  export let props;
</script>

<div class="preview">
  <svelte:component this={child} {...props} />
</div>
