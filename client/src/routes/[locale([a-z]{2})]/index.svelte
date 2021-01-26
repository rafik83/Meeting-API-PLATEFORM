<script>
  import { _ } from 'svelte-i18n';

  import RegistrationForm from '../../components/RegistrationForm.svelte';
  import RegistrationSSO from '../../components/RegistrationSSO.svelte';

  const handleSubmitForm = (e) => {
    console.log('values', e.detail);
  };
</script>

<div
  class="p-8 flex justify-center flex-col items-center rounded-lg m-auto shadow-xl bg-gray-50 md:w-144 sm:w-auto"
>
  <div class="md:w-80 sm:w-full">
    <div class="flex flex-col">
      <h1 class="text-5xl font-bold my-0 text-gray-500">
        {$_('registration.title')}
      </h1>
      <h2 class="text-2xl font-bold text-community-300">
        {$_('registration.subtitle')}
      </h2>
      <RegistrationForm on:submitform={handleSubmitForm} />
    </div>
  </div>
  <hr
    class="w-full ms:w-auto my-6 overflow-visible text-center h-1.5 border-t border-gray-300 color-gray-400"
  />
  <div class="bg-gray-50 font-bold text-gray-400 flex px-1.5 text-lg -mt-11">
    {$_('registration.or')}
  </div>
  <div class="md:w-80 sm:w-full flex items-center justify-center flex-row">
    <p class="font-semibold mr-2">{$_('registration.buttonSSO')}</p>
    <RegistrationSSO
      type={'vimeet'}
      classSSO={'bg-sso-vimeet'}
      url={'vimeet.com'}
    />
    <RegistrationSSO
      type={'linkedin'}
      classSSO={'bg-sso-linkedin'}
      url={'linkedin.com'}
    />
  </div>
  <div class="md:w-80 sm:w-full">
    <p class="text-base text-community-300 font-semibold text-center mt-5">
      {$_('registration.eventVimeet')}
    </p>
    <a
      href="http://"
      class="w-full flex justify-center mt-1 items-center font-semibold rounded-lg bg-community-300 h-12 text-gray-50">
      {$_('registration.log')}
    </a>
  </div>
</div>
