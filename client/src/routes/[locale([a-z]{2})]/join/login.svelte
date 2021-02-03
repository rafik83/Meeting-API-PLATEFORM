<script>
  import { _ } from 'svelte-i18n';

  import { stores, goto } from '@sapper/app';
  const { session } = stores();
  import { authenticate, findById } from '../../../repository/account';
  import { addError, discardError } from '../../../stores/registrationError';
  import { toHomePage, toRegistrationPage } from '../../../modules/routing';
  import LoginForm from '../../../components/LoginForm.svelte';
  import Separator from '../../../components/Separator.svelte';

  const handleSubmitForm = async (e) => {
    try {
      discardError();
      const response = await authenticate(e.detail);
      const { location } = response.headers;

      const user = await findById(location.split('/')[3]);
      $session.user = user;
      goto(toHomePage());
    } catch (e) {
      addError($_('registration.wrong_username_or_password'));
    }
  };
</script>

<div class="">
  <h1 class="md:text-5xl text-4xl font-bold my-0 text-gray-500">
    {$_('registration.title')}
  </h1>
  <h2 class="md:text-2xl text-xl font-bold text-community-300">
    {$_('registration.subtitle')}
  </h2>
</div>

<LoginForm on:submitform={handleSubmitForm} />

<Separator />

<p class="text-base text-community-300 font-semibold text-center mt-5">
  {$_('registration.no_account')}
</p>
<a
  href={toRegistrationPage()}
  class="w-full flex justify-center mt-1 items-center font-semibold rounded-lg bg-community-300 h-12 text-gray-50">
  {$_('registration.register')}
</a>
