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
    let user;
    let mainCommunityObjective;

    try {
      user = await findById(userId);
      mainCommunityObjective = await getCommunityMainObjectives(communityId);
    } catch (error) {
      if (error.response && error.response.status > 201) {
        console.error(error);
        this.error(error.response.status);
      }
    }

    return {
      user,
      currentUserMemberId: getUserMemberIdInCommunity(user, communityId),
      ...mainCommunityObjective,
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
  import { setBaseUrl } from '../../../modules/axios';
  import { capitalize } from '../../../modules/textUtils';
  const { session } = stores();
  setBaseUrl($session.apiUrl);

  export let user;
  export let tags;
  export let min;
  export let max;
  export let currentUserMemberId;
  export let goalId;
  let selectedTags = [];
  let errorMessage;
  const title = $_('registration.hello');
  const subtitle = capitalize(`${user.firstName} ${user.lastName}`);

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
        const mainObjectiveTag = selectedTags.find((item) => {
          return item.priority === 1;
        });
        await saveCommunityGoal(currentUserMemberId, {
          goal: goalId,
          tags: selectedTags,
        });
        await goto(toOnboardingStep('4-1', mainObjectiveTag.id));
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

<OnboardingContainer step="3" {title} {subtitle}>
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

  <div class="flex justify-between md:w-1/2 m-auto" slot="button">
    <Button
      withMargin
      on:click={async () => await goto(toOnboardingStep('2-1'))}
    >
      {$_('messages.previous')}
    </Button>
    <Button withMarging on:click={handleSubmitGoals}>
      {$_('messages.next')}
    </Button>
  </div>
</OnboardingContainer>
