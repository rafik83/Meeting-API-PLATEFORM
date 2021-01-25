<script context="module">
  /*  
      This is the page linked to '/' route
      The purpose of this component is only to redirect to the folder containing the localized pages.
      For example, by going to the route `/` the user will be redirected to the route '/fr'.

      You'll find all the localized page in the follder named [locale([a-z]{2})]
   */
  export async function preload(page, session) {
    console.log(session.locale);
    return this.redirect(302, session.locale);
  }
</script>
