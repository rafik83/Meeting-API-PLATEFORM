<script context="module">
  import {
    findById,
    getUserMemberIdInCommunity,
  } from '../../../repository/account';

  export async function preload(
    page,
    { userId, isAuthenticated, communityId }
  ) {
    const queryParam = page.query;

    const tagId = queryParam.tagId;

    if (!isAuthenticated) {
      this.redirect(302, toHomePage());
    }

    if (!tagId) {
      this.error(404, 'No Goal id found');
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

    return {
      communityId,
      user,
      tagId,
      currentUserMemberId: getUserMemberIdInCommunity(user, communityId),
    };
  }
</script>

<script>
  import { _ } from 'svelte-i18n';
  import OnboardingContainer from '../../../components/OnboardingContainer.svelte';
  import Button from '../../../components/Button.svelte';
  import H3 from '../../../components/H3.svelte';
  import Loader from '../../../components/Loader.svelte';
  import MainObjectiveTagsNavigator from '../../../components/MainObjectiveTagsNavigator.svelte';
  import IconSatellites from '../../../ui-kit/icons/IconSatellites/IconSatellites.svelte';
  import { onMount } from 'svelte';
  import {
    getMemberGoals,
    saveCommunityGoal,
  } from '../../../repository/member';
  import { getCommunityGoals } from '../../../repository/community';
  import MainObjectiveTags from '../../../components/MainObjectiveTags.svelte';
  import {
    buildTagTree,
    createGroupOfTreeItemsByParent,
    filterTagsWithNoPriorities,
    getFirstLevelTreeItems,
    getTagsFromMemberGoal,
    setTagPriorityToNullIfNotDefined,
    updatePriorities,
    updatePrioritiesWithinGroupedTreeItems,
  } from '../../../modules/tagManagement';
  import { setBaseUrl } from '../../../modules/axios';

  import { goto, stores } from '@sapper/app';
  import { toHomePage, toOnboardingStep } from '../../../modules/routing';
  import Cookies from 'js-cookie';
  import Error from '../../../components/Error.svelte';

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  export let user;
  export let communityId;
  export let tagId;
  export let currentUserMemberId;

  let min;
  let max = null;
  let errorMessage = '';
  let selectedTagCount = 0;
  let loading = true;

  let memberObjectives = [];
  let communityGoals = [];
  let firstLevelTreeTags = [];
  let groupedTreeItems = [];
  let memberGoalTags = [];
  let selectedTags = [];
  let currentGoal;
  let firstLevelTreeItems = [];
  let noDataToDisplay = false;

  const handleSelectedTag = (e) => {
    if (!max || selectedTagCount < max || e.detail.priority) {
      memberGoalTags = updatePriorities(e.detail, memberGoalTags);

      selectedTags = filterTagsWithNoPriorities(memberGoalTags);
      selectedTagCount = selectedTags.length;

      groupedTreeItems = updatePrioritiesWithinGroupedTreeItems(
        memberGoalTags,
        groupedTreeItems
      );
    }
  };

  const handleSubmitGoals = async () => {
    errorMessage = '';

    if (selectedTags.length < min) {
      errorMessage = $_('validation.not_enough_tag_selected', {
        values: {
          value: min - selectedTags.length,
        },
      });
    }

    if (selectedTagCount >= min) {
      try {
        await saveCommunityGoal(currentUserMemberId, {
          goal: currentGoal.id,
          tags: selectedTags,
        });
        await goto(toOnboardingStep('4-3'));
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

  onMount(async () => {
    memberObjectives = await getMemberGoals(communityId);

    communityGoals = await getCommunityGoals(communityId);

    currentGoal = communityGoals.find((goalItem) => {
      return goalItem.tag && goalItem.tag.id == tagId;
    });

    const currentMemberGoal = memberObjectives.find(({ goal }) => {
      const { nomenclature } = goal;
      return nomenclature.id == tagId;
    });

    if (currentGoal && currentMemberGoal) {
      max = currentGoal.max;
      min = currentGoal.min;

      memberGoalTags = getTagsFromMemberGoal(currentMemberGoal);
      memberGoalTags = setTagPriorityToNullIfNotDefined(memberGoalTags);

      const tree = buildTagTree(memberGoalTags);

      firstLevelTreeItems = getFirstLevelTreeItems(tree);
      firstLevelTreeTags = firstLevelTreeItems.map((item) => item.tag);

      groupedTreeItems = createGroupOfTreeItemsByParent(
        firstLevelTreeItems,
        memberGoalTags
      );
    } else {
      noDataToDisplay = true;
    }

    loading = false;
  });
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
      {#if noDataToDisplay || groupedTreeItems.length === 0}
        <div class="w-full">
          <Error message={$_('messages.error_has_occured')} />
        </div>
      {:else}
        <div class="w-full">
          <H3>{$_('cards.select_items_of_your_main_objective')}.</H3>
        </div>

        <div class="md:flex justify-between flex-wrap">
          <div class="w-full">
            <MainObjectiveTagsNavigator tags={firstLevelTreeTags} />
          </div>
        </div>

        {#if max}
          <div class="w-full flex justify-center">
            <p
              class="text-right mb-4 text-sm {selectedTagCount === max
                ? 'text-success'
                : ''}"
            >{selectedTagCount}/{max} {$_('onboarding.select')}</p>
          </div>
        {/if}
        {#if errorMessage}
          <Error message={errorMessage} />
        {/if}

        {#each groupedTreeItems as { children, parent }}
          <MainObjectiveTags
            titleTag={parent}
            tags={children}
            on:click={handleSelectedTag}
          />
        {/each}
      {/if}
    </section>

    <div class="flex  justify-between w-1/2 m-auto" slot="button">
      <Button
        withMarging
        on:click={async () => await goto(toOnboardingStep('4-1', tagId))}
      >
        {$_('messages.previous')}
      </Button>
      <Button on:click={handleSubmitGoals}>
        {$_('messages.next')}
      </Button>
    </div>
  </OnboardingContainer>
{/if}
