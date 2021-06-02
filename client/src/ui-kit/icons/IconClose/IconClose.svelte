<script>
  export let fill = 'currentColor';
</script>

<svg
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 18.811 18.811"
  {...$$restProps}
  on:click
  on:mouseover
  on:mouseenter
  on:mouseleave
  on:keydown
>
  <slot />
  <path
    {fill}
    d="M26.334,9.4,24.452,7.523l-7.524,7.525L9.4,7.523,7.523,9.4l7.525,7.524L7.523,24.452,9.4,26.334l7.524-7.525,7.524,7.525,1.882-1.882-7.525-7.524Z"
    transform="translate(-7.523 -7.523)"
  />
</svg>
