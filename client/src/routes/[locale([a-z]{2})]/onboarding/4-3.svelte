<script context="module">
  import { findById } from '../../../repository/account';
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';

  export async function preload(
    page,
    { userId, isAuthenticated, communityId }
  ) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }
    const user = await findById(userId);

    return {
      user,
      communityId,
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';

  import { getMemberGoals } from '../../../repository/member';
  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import IconSatellite from '../../../ui-kit/icons/IconSatellite/IconSatellite.svelte';
  import { goto } from '@sapper/app';
  import { stores } from '@sapper/app';
  import { onMount } from 'svelte';
  import { getTagsFromMemberGoal } from '../../../modules/tagManagement';
  import TagButton from '../../../components/TagButton.svelte';
  import { setBaseUrl } from '../../../modules/axios';
  import Loader from '../../../components/Loader.svelte';

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  export let user;
  export let communityId;
  let tags;
  let isLoading = true;

  const handleSelectTag = async (e) => {
    await goto(toOnboardingStep('4-1', e.detail.id));
  };

  onMount(async () => {
    const goals = await getMemberGoals(communityId);

    const goal = goals.find((goal) => {
      return !goal.parent;
    });
    tags = getTagsFromMemberGoal(goal);

    if (tags.length === 0) {
      // if there is no tag that means the user has'nt selected any tags at step 3
      await goto(toOnboardingStep('3'));
    }

    isLoading = false;
  });
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

{#if isLoading}
  <Loader />
{:else}
  <OnboardingContainer step="4" {user}>
    <div slot="icon" class="w-10/12">
      <IconSatellite width="90%" class="mx-auto" />
    </div>

    <section slot="content" class="w-full h-full md:flex justify-center">
      <div class="md:w-3/4 my-8">
        <h3 class="font-semibold my-4">
          {$_('onboarding.detail_another_objective')}
        </h3>
        <div class="flex-wrap my-8 md:flex">
          {#each tags as tag}
            <div class="md:w-1/2">
              <TagButton
                name={tag.name}
                id={tag.id}
                on:click={handleSelectTag}
              />
            </div>
          {/each}
        </div>
      </div>
    </section>
  </OnboardingContainer>
{/if}
