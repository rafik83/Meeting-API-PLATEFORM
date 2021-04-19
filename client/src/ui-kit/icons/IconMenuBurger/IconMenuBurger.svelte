<style>
  svg {
    transition: transform 0.3s ease-in-out;
  }

  svg line {
    transition: transform 0.3s ease-in-out;
  }
</style>

<script>
  export let open = false;
  export let stroke = '#2a2e43';
</script>

<svg
  viewBox="0 0 32 24"
  class={open ? 'transform scale-75' : ''}
  {...$$restProps}
  on:click
  on:mouseover
  on:mouseenter
  on:mouseleave
  on:keydown>
  <line
    {stroke}
    stroke-width="3"
    transform={open ? 'translate(6 0) rotate(45)' : ''}
    x1="0"
    y1="2"
    x2="32"
    y2="2"
  />
  <line
    {stroke}
    stroke-width="3"
    class={open ? 'opacity-0' : ''}
    x1="0"
    y1="12"
    x2="32"
    y2="12"
  />
  <line
    {stroke}
    stroke-width="3"
    transform={open ? 'translate(-12 9) rotate(-45)' : ''}
    x1="0"
    y1="22"
    x2="32"
    y2="22"
  />
</svg>
