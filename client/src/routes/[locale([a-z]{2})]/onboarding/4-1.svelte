<script context="module">
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';
  import {
    findById,
    getUserMemberIdInCommunity,
  } from '../../../repository/account';
  export async function preload(
    page,
    { isAuthenticated, communityId, userId }
  ) {
    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }

    let user;

    try {
      user = await findById(userId);
    } catch (error) {
      if (error.response && error.response.status > 201) {
        console.error(error);
        this.error(error.response.status);
      }
    }

    const queryParam = page.query;
    const tagId = queryParam.tagId;

    /*
     * !! Edge Case !!
     *  We expect to find the tagId in the url as query parameter
     *  If no tagId has been found  we redirect the user
     */

    if (!tagId) {
      this.redirect(302, toOnboardingStep('3'));
    }

    return {
      user,
      tagId,
      communityId,
      currentUserMemberId: getUserMemberIdInCommunity(user, communityId),
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';
  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import Button from '../../../components/Button.svelte';
  import MainObjectiveTagsNavigator from '../../../components/MainObjectiveTagsNavigator.svelte';
  import IconSatellites from '../../../ui-kit/icons/IconSatellite/IconSatellite.svelte';
  import { onMount } from 'svelte';
  import SecondaryObjectiveSelect from '../../../components/SecondaryObjectiveSelect.svelte';
  import {
    buildTagTree,
    getFirstLevelTreeItems,
  } from '../../../modules/tagManagement';
  import { setBaseUrl } from '../../../modules/axios';

  import { stores } from '@sapper/app';
  import Loader from '../../../components/Loader.svelte';
  import { getCommunityGoals } from '../../../repository/community';

  import { secondaryGoals } from '../../../stores/secondaryGoalsStore';
  import { saveCommunityGoal } from '../../../repository/member';
  import Cookies from 'js-cookie';
  import { goto } from '@sapper/app';
  import Error from '../../../components/Error.svelte';
  import H2 from '../../../components/H2.svelte';
  import Tag from '../../../components/Tag.svelte';
  import { sizes } from '../../../constants';

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  export let user;
  export let communityId;
  export let tagId;
  export let currentUserMemberId;
  let currentGoal;
  let communityGoals;
  let firstLevelTreeItems = [];
  let loading = true;
  let min;
  let max;
  let errorMessage;
  let goalTagName;

  onMount(async () => {
    communityGoals = await getCommunityGoals(communityId);

    currentGoal = communityGoals.find((goalItem) => {
      return goalItem.tag && goalItem.tag.id == tagId;
    });

    min = currentGoal.min;
    max = currentGoal.max;
    goalTagName = currentGoal.tag.name;

    if (currentGoal) {
      const tree = buildTagTree(currentGoal.nomenclature.tags);

      firstLevelTreeItems = getFirstLevelTreeItems(tree).filter(
        (treeItem) => treeItem.children.length > 0
      );
    }

    loading = false;
  });

  const handleSubmitGoals = async () => {
    if ($secondaryGoals.length < min) {
      errorMessage = $_('validation.not_enough_tag_selected', {
        values: {
          value: min - $secondaryGoals.length,
        },
      });

      return;
    }

    const payload = {
      goal: currentGoal.id,
      tags: $secondaryGoals.map(({ id }) => {
        return {
          id,
          priority: null,
        };
      }),
    };

    try {
      await saveCommunityGoal(currentUserMemberId, payload);
      await goto(toOnboardingStep('4-2', tagId));
    } catch (e) {
      if (e.response.status === 401) {
        $session.userId = null;
        Cookies.remove('userId');
        await goto(toHomePage());
      }
      errorMessage = $_('messages.error_has_occured');
    }
  };
</script>

<svelte:head>
  <title>{$_('onboarding.title')}</title>
</svelte:head>

{#if loading}
  <Loader />
{:else}
  <OnboardingContainer step="4" {user}>
    <div slot="icon" class="w-10/12">
      <IconSatellites width="90%" class="mx-auto" />
    </div>

    <section slot="content" class="w-full h-full">
      <div class="w-full pl-5">
        <div class="flex items-center" />
        <H2 community>{$_('onboarding.your_objective')}</H2>
        <Tag dark size={sizes.LARGE}>
          {goalTagName.toUpperCase()}
        </Tag>
        <p>{$_('onboarding.please_detail_your_goal')}</p>
      </div>

      <div class="w-full">
        <MainObjectiveTagsNavigator
          tags={firstLevelTreeItems.map((item) => item.tag)}
        />
      </div>

      {#if errorMessage}
        <Error message={errorMessage} />
      {/if}

      {#if max}
        <div class="w-full flex justify-center">
          <p
            class="text-right mb-4 text-sm {$secondaryGoals.length === max
              ? 'text-success'
              : ''}"
          >
            {$secondaryGoals.length}/{max}
            {$_('onboarding.select')}
          </p>
        </div>
      {/if}
      {#each firstLevelTreeItems as goalTreeItem}
        <a name={goalTreeItem.tag.id}><!-- intentionally blank --></a>
        <SecondaryObjectiveSelect
          {max}
          titleTag={goalTreeItem.tag}
          {goalTreeItem}
        />
      {/each}
    </section>
    <div class="flex justify-between w-1/2 m-auto" slot="button">
      <Button
        withMargin
        on:click={async () => await goto(toOnboardingStep('3'))}
      >
        {$_('messages.previous')}
      </Button>
      <Button on:click={handleSubmitGoals}>
        {$_('messages.next')}
      </Button>
    </div>
  </OnboardingContainer>
{/if}
