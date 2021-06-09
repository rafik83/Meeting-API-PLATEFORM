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

<h1>Entreprise n° {id}</h1>
