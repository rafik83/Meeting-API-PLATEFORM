<script>
  export let stroke = '#fff';
</script>

<svg
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 21.775 49.875"
  {...$$restProps}
  on:click
  on:mouseover
  on:mouseenter
  on:mouseleave
  on:keydown
  ><slot />
  <g transform="translate(1.901 0.921)"
    ><g transform="translate(18.69 48.032) rotate(180)"
      ><path
        {stroke}
        stroke-miterlimit="10"
        stroke-width="3px"
        fill="none"
        d="M0,0,18.69,24.016,0,48.032"
      /></g
    ></g
  ></svg
>
