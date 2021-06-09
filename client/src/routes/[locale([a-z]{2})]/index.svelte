<script context="module">
  import { createMember } from '../../repository/member';
  import { register, findById, authenticate } from '../../repository/account';

  export async function preload(
    { query },
    { communityId, userId, isAuthenticated }
  ) {
    let countryList = [];

    let errorMessage = '';
    let user;
    const target = query.target;

    if (userId && isAuthenticated) {
      user = await findById(userId);
    }

    return {
      user,
      countryList,
      target,
      errorMessage,
      communityId,
    };
  }
</script>

<script>
  import { goto, stores } from '@sapper/app';
  import { getContext, onMount } from 'svelte';
  import { _ } from 'svelte-i18n';
  import Cookies from 'js-cookie';

  import LoginForm from '../../components/LoginForm.svelte';
  import RegistrationForm from '../../components/RegistrationForm.svelte';
  import {
    toCompanyPage,
    toMemberPage,
    toOnboardingStep,
    toRegistrationStep,
    toVideoConference,
  } from '../../modules/routing';
  import { setBaseUrl } from '../../modules/axios';
  import { registrationSteps } from '../../constants';
  import Nav from '../../components/Nav.svelte';
  import { buildFakeFeaturingSlides } from '../../__fixtures__/FakeFeaturingSlide';
  import Loader from '../../components/Loader.svelte';
  import {
    getCommunityCards,
    getCommunityLists,
  } from '../../repository/community';

  export let target;
  export let user;
  export let errorMessage;
  export let communityId;

  let FeaturingSlider;
  let CardSlider;
  let communityLists = [];
  let communityCardsPromises;
  let loading = true;

  onMount(async () => {
    // See doc here: https://sapper.svelte.dev/docs/#Third-party_libraries_that_depend_on_window
    const featuringSliderModule = await import(
      '../../components/FeaturingSlider.svelte'
    );
    FeaturingSlider = featuringSliderModule.default;

    const cardSliderModule = await import('../../components/CardSlider.svelte');

    CardSlider = cardSliderModule.default;

    try {
      communityLists = await getCommunityLists(communityId);
      const communityListIds = communityLists.map((list) => list.id);

      communityCardsPromises = communityListIds.map((listId) =>
        getCommunityCards(communityId, listId)
      );
    } catch (e) {
      errorMessage = $_('messages.error_has_occured');
    } finally {
      loading = false;
    }
  });

  const { open, close } = getContext('simple-modal');

  const { session } = stores();
  setBaseUrl($session.apiUrl);

  const handleSignIn = async (values) => {
    try {
      const userId = await authenticate(values);

      await createMember(communityId);

      $session.userId = userId;
      $session.isAuthenticated = true;
      Cookies.set('userId', userId, {
        expires: 365,
      });

      close();

      await goto(toOnboardingStep(1));
    } catch (e) {
      errorMessage = $_('messages.error_has_occured');
    }
  };

  const handleSignUp = async (values) => {
    try {
      $session.userId = (await register(values)).id;
      await goto(toRegistrationStep(registrationSteps.SIGN_IN));
    } catch (e) {
      if (e.response.status === 422) {
        errorMessage = $_('registration.user_already_exists');
      } else {
        errorMessage = $_('messages.error_has_occured');
      }
    }
  };

  const modalOptions = {
    styleCloseButton: {
      color: '#2A2E43',
      boxShadow: 'none',
    },
    styleWindow: {
      width: '30rem',
    },
  };

  $: switch (target) {
    case registrationSteps.SIGN_IN:
      openSignInModal();
      break;

    case registrationSteps.SIGN_UP:
      open(
        RegistrationForm,
        {
          onSubmitForm: handleSignUp,
          errorMessage,
          signInUrl: toRegistrationStep(registrationSteps.SIGN_IN),
        },
        modalOptions
      );
      break;
  }

  const openSignInModal = () => {
    open(
      LoginForm,
      {
        onSubmitForm: handleSignIn,
        errorMessage,
        signUpUrl: toRegistrationStep(registrationSteps.SIGN_UP),
      },
      modalOptions
    );
  };

  const handleMeetMember = async () => {
    if (!user) {
      openSignInModal();
      return;
    }
    //TODO; use real room id
    const roomId = 898999;
    await goto(toVideoConference(roomId));
  };
  const handleViewMemberProfile = async (e) => {
    if (!user) {
      openSignInModal();
      return;
    }

    await goto(toMemberPage(e.detail.id));
  };
  const handleGenerateNewLeads = async (e) => {
    if (!user) {
      openSignInModal();
      return;
    }

    await goto(toCompanyPage(e.detail.id));
  };
</script>

<section class="h-full w-full pb-28 overflow-x-hidden">
  <Nav {user} />

  {#if loading}
    <Loader />
  {:else}
    <svelte:component
      this={FeaturingSlider}
      slides={buildFakeFeaturingSlides()}
    />

    <section class="w-full">
      {#each communityCardsPromises as communityCardsPromise, i}
        {#await communityCardsPromise}
          <div class="my-8">
            <Loader withTitle={false} />
          </div>
        {:then cards}
          {#if cards.length > 0}
            <svelte:component
              this={CardSlider}
              on:meet_member={handleMeetMember}
              on:view_member_profile={handleViewMemberProfile}
              on:generate_new_leads={handleGenerateNewLeads}
              title={communityLists[i].title}
              id={`homepage-slider-${communityLists[i].id}`}
              {cards}
            />
          {/if}
        {/await}
      {/each}
    </section>
  {/if}
</section>
