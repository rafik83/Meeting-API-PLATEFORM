<script context="module">
  export const preload = ({ params }) => {
    return {
      roomId: params.room,
    };
  };
</script>

<script>
  export let roomId;
</script>

<h1>Starting viso conference in room n° {roomId}</h1>
