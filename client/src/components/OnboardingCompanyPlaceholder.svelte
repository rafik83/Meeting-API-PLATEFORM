<script>
  import { _ } from 'svelte-i18n';
  import H3 from './H3.svelte';
  import Button from './Button.svelte';
  import { sizes } from '../constants';
  import IconQuestionMark from '../ui-kit/icons/IconQuestionMark/IconQuestionMark.svelte';

  export let isSelected = false;
</script>

<div
  class="flex flex-col justify-center items-center text-center w-72 h-72 p-5 m-2 shadow-lg rounded-2xl border bg-gray-100 opacity-40 {isSelected
    ? 'border-community-300'
    : 'border-gray-200'}"
>
  <div
    class="w-20 h-20 rounded-full overflow-hidden mb-3 bg-gray-200 flex items-center justify-center"
  >
    <IconQuestionMark width="30px" fill="#FBFBFD" />
  </div>

  <H3>{$_('registration.cant_find_company_in_list')}</H3>
  <H3>{$_('registration.you_can_create_it')}</H3>
  <div>
    <Button on:click kind="secondary" fullWidth={false} size={sizes.SMALL}
      >{$_('registration.register_my_company')}</Button
    >
  </div>
</div>
