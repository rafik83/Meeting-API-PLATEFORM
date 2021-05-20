<script>
  export let fill = 'currentColor';
</script>

<svg
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 30 79"
  {...$$restProps}
  on:click
  on:mouseover
  on:mouseenter
  on:mouseleave
  on:keydown
  ><slot /><g transform="translate(-1697 -410)"
    ><text
      {fill}
      font-family="Poppins-Regular, Poppins"
      font-size="56px"
      transform="translate(1712 469)"><tspan x="-14.672" y="0">?</tspan></text
    ></g
  ></svg
>
