<script>
  export let fill = '#fff';
</script>

<svg
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 9.58 48.989"
  {...$$restProps}
  on:click
  on:mouseover
  on:mouseenter
  on:mouseleave
  on:keydown
  ><slot /><path
    {fill}
    d="M12609,2585.988h0V2537h8.221l-3.188,19.005,4.548,6.469-6.4,4.557Z"
    transform="translate(-12609 -2537)"
  /></svg
>
