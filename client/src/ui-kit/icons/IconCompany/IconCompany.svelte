<script>
  export let fill = 'currentColor';
</script>

<svg
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 17.256 19.721"
  {...$$restProps}
  on:click
  on:mouseover
  on:mouseenter
  on:mouseleave
  on:keydown
  ><slot />
  <path
    {fill}
    fill-rule="evenodd"
    d="M4.233,4.465A2.465,2.465,0,0,1,6.7,2h9.86a2.465,2.465,0,0,1,2.465,2.465V19.256a1.233,1.233,0,1,1,0,2.465h-3.7a1.233,1.233,0,0,1-1.233-1.233V18.023a1.233,1.233,0,0,0-1.233-1.233H10.4a1.233,1.233,0,0,0-1.233,1.233v2.465A1.233,1.233,0,0,1,7.93,21.721h-3.7a1.233,1.233,0,0,1,0-2.465ZM7.93,5.7H10.4V8.163H7.93Zm2.465,4.93H7.93v2.465H10.4ZM12.86,5.7h2.465V8.163H12.86Zm2.465,4.93H12.86v2.465h2.465Z"
    transform="translate(-3 -2)"
  /></svg
>
