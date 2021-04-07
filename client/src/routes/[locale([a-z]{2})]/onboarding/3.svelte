<script context="module">
  import {
    findById,
    getUserMemberIdInCommunity,
  } from '../../../repository/account';
  import { getCommunityMainObjectives } from '../../../repository/community';

  export async function preload(
    page,
    { userId, isAuthenticated, communityId }
  ) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }
    const user = await findById(userId);
    const { tags, min, max, goalId } = await getCommunityMainObjectives(
      communityId
    );

    return {
      goalId,
      user,
      min,
      max,
      tags,
      currentUserMemberId: getUserMemberIdInCommunity(user, communityId),
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';
  import Button from '../../../components/Button.svelte';
  import TagSelector from '../../../components/TagSelector.svelte';
  import { saveCommunityGoal } from '../../../repository/member';
  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import IconSatellite from '../../../ui-kit/icons/IconSatellite/IconSatellite.svelte';
  import { goto } from '@sapper/app';
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';
  import Cookies from 'js-cookie';
  import { stores } from '@sapper/app';
  const { session } = stores();

  export let user;
  export let tags;
  export let min;
  export let max;
  export let currentUserMemberId;
  export let goalId;
  let selectedTags = [];
  let errorMessage;

  const handleSubmitGoals = async () => {
    errorMessage = '';

    if (selectedTags.length < min) {
      errorMessage = $_('validation.not_enough_tag_selected', {
        values: {
          value: min - selectedTags.length,
        },
      });
    }

    if (selectedTags.length >= min) {
      try {
        await saveCommunityGoal(currentUserMemberId, {
          goal: goalId,
          tags: selectedTags,
        });
        await goto(toOnboardingStep(4));
      } catch (e) {
        if (e.response.status === 401) {
          $session.userId = null;
          Cookies.remove('userId');
          await goto(toHomePage());
        }
        errorMessage = $_('messages.error_has_occured');
      }
    }
  };
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

<OnboardingContainer step="3" {user}>
  <div slot="icon" class="w-10/12">
    <IconSatellite width="90%" class="mx-auto" />
  </div>

  <section slot="content" class="w-full h-full md:flex justify-center">
    <div class="md:w-3/4">
      <TagSelector
        {errorMessage}
        title={$_('onboarding.select_your_goals', {
          values: { n: min },
        })}
        {min}
        {max}
        {tags}
        bind:selectedTags
      />
    </div>
  </section>

  <div slot="button">
    <Button on:click={handleSubmitGoals}>
      {$_('registration.next')}
    </Button>
  </div>
</OnboardingContainer>
