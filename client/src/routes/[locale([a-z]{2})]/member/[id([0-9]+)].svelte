<script context="module">
  export const preload = ({ params }) => {
    return {
      id: params.id,
    };
  };
</script>

<script>
  export let id;
</script>

<h1>Member n° {id}</h1>
