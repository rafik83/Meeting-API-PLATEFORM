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
  <g transform="translate(1.184 0.921)"
    ><path
      {stroke}
      fill="none"
      stroke-miterlimit="10"
      stroke-width="3px"
      d="M0,0,18.69,24.016,0,48.032"
    /></g
  ></svg
>
