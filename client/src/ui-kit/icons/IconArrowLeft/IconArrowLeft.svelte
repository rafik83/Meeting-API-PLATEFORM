<script>
  export let stroke = "#2a2e43";
</script>
<svg
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 13.214 27.875"
  {...$$restProps}
  on:click
  on:mouseover
  on:mouseenter
  on:mouseleave
  on:keydown>
  <slot />
  <g fill="none" {stroke}>
    <path
      stroke-width="3px"
      stroke-miterlimit="10"
      d="M0,0,10.13,13.016,0,26.033"
      transform="translate(12.031 26.954) rotate(180)"
    />
  </g>
</svg>
