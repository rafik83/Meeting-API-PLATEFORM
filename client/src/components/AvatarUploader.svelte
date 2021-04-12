<script>
  import { _ } from 'svelte-i18n';
  import FileUploader from './FileUploader.svelte';
  export let fileMaxSize;
  let loading;

  export let uploadedFile;

  const handleUploadFile = ({ detail }) => {
    uploadedFile = detail[0];
  };
</script>

<div class="h-full mt-5 md:px-5">
  <h2 class="text-community-300 md:my-6 mb-2 font-semibold text-xl md:text-2xl">
    {$_('registration.attention_members')}
  </h2>
  <h4 class="font-semibold mb-8">{$_('registration.add_photo')}</h4>

  <div
    class="md:h-3/6 box-border flex text-center items-center justify-center flex-col"
  >
    <FileUploader
      on:fileUploaded={handleUploadFile}
      accept={['image/jpg', 'image/png']}
      {loading}
      maxSize={fileMaxSize}
    />
  </div>
</div>
