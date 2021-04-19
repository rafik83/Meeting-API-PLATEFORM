<script context="module">
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';
  export async function preload(page, { isAuthenticated }) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }

    const queryParam = page.query;
    const tagId = queryParam.tagId;

    /*
     * !! Edge Case !!
     *  We expect to find the tagId in the url as query parameter
     *  If no tagId has been found  we redirect the user
     */

    if (!tagId) {
      this.redirect(302, toOnboardingStep('4'));
    }

    return {
      tagId,
    };
  }
</script>

<script>
  export let tagId;
</script>

Le user détaille ce tag {tagId}
