<script>
  export let stroke = '#2a2e43';
</script>

<svg
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 76 76"
  {...$$restProps}
  on:click
  on:mouseover
  on:mouseenter
  on:mouseleave
  on:keydown
  ><slot />
  <defs
    ><style>
      .IconArrowLeftWithCircleFiltered {
        filter: url(#IconArrowLeftWithCircleFilter);
      }
    </style><filter
      id="IconArrowLeftWithCircleFilter"
      x="0"
      y="0"
      width="76"
      height="76"
      filterUnits="userSpaceOnUse"
      ><feOffset dy="3" input="SourceAlpha" /><feGaussianBlur
        stdDeviation="7.5"
        result="b"
      /><feFlood flood-opacity="0.122" /><feComposite
        operator="in"
        in2="b"
      /><feComposite in="SourceGraphic" /></filter
    ></defs
  ><g transform="translate(-141.525 -678.525)"
    ><g
      class="IconArrowLeftWithCircleFiltered"
      transform="matrix(1, 0, 0, 1, 141.52, 678.52)"
      ><rect
        fill="#fff"
        width="31"
        height="31"
        rx="15.5"
        transform="translate(22.5 19.5)"
      /></g
    ><g transform="translate(181.51 719.889) rotate(180)"
      ><path
        {stroke}
        fill="none"
        stroke-miterlimit="10"
        stroke-width="3px"
        d="M0,0,5.144,6.61,0,13.221"
      /></g
    ></g
  ></svg
>
