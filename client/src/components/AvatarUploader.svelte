<script>
  import { _ } from 'svelte-i18n';
  import DragAndDrop from './DragAndDrop.svelte';
  import Button from './Button.svelte';
  import RegistrationPipeLineHeader from './RegistrationPipeLineHeader.svelte';

  let accept = ['image/jpg', 'image/jpeg', 'image/png'];
  let maxSize = 1 * 1024 * 1024; // 1Mb
  let dragAndDropName = 'Account avatar';
  let uploadedFile;

  export let onUploadAvatar;
  export let user;
  export let loading;

  const handleUploadFile = ({ detail }) => {
    uploadedFile = detail[0];
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    onUploadAvatar(uploadedFile);
  };
</script>

<div class="h-full px-5">
  <RegistrationPipeLineHeader
    title={$_('registration.hello') + '.'}
    subtitle={user.firstName + ' ' + user.lastName}
  />

  <h2 class="text-community-300 my-6 font-semibold text-2xl pl-8">
    {$_('registration.attention_members')}
  </h2>
  <h4 class="font-semibold mb-1">{$_('registration.add_photo')}</h4>

  <div class="h-40 flex text-center items-center justify-center flex-col">
    <DragAndDrop
      on:fileUploaded={handleUploadFile}
      {loading}
      {accept}
      {maxSize}
      name={dragAndDropName}
      textDropZone={$_('registration.upload_avatar')}
    />
  </div>

  <Button type="submit" kind="primary" on:click={handleSubmit}>
    {$_('registration.next')}
  </Button>
</div>
