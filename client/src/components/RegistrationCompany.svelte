<script>
  import { _ } from 'svelte-i18n';
  import * as yup from 'yup';
  import { extractErrors } from '../modules/validator';

  import DragAndDrop from './DragAndDrop.svelte';
  import CompanyForm from './CompanyForm.svelte';
  import Button from './Button.svelte';
  import RegistrationPipeLineHeader from './RegistrationPipeLineHeader.svelte';

  export let countryList;
  export let onCreateCompany;
  export let user;

  let accept = ['image/jpg', 'image/jpeg', 'image/png'];
  let maxSize = 1 * 1024 * 1024; // 1Mb
  let maxDescriptionLength = 300;
  let dragAndDropName = 'Company logo';
  let uploadedFile;

  let companyFormValues;

  let errors = {};

  const handleUploadFile = ({ detail }) => {
    uploadedFile = detail[0];
  };

  const validationSchema = yup.object().shape({
    name: yup.string().required($_('validation.field_required')),
    countryCode: yup.string().required($_('validation.field_required')),
    website: yup
      .string()
      .url($_('validation.wrong_url'))
      .required($_('validation.field_required')),
    activity: yup
      .string()
      .max(
        maxDescriptionLength,
        $_('validation.maximum_characters', { value: maxDescriptionLength })
      ),
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await validationSchema.validate(companyFormValues, {
        abortEarly: false,
      });
      errors = {};
      onCreateCompany(uploadedFile, companyFormValues);
    } catch (err) {
      errors = extractErrors(err);
    }
  };
</script>

<div class="h-full px-5">
  <RegistrationPipeLineHeader
    title={$_('registration.hello') + '.'}
    subtitle={user.firstName + ' ' + user.lastName}
  />

  <p class="text-community-300 font-semibold pb-4">
    {$_('registration.create_your_company') + '.'}
  </p>

  <div class="h-52">
    <p class="text-error " />
    <DragAndDrop
      on:fileUploaded={handleUploadFile}
      {accept}
      {maxSize}
      name={dragAndDropName}
    />
  </div>
  <CompanyForm
    {errors}
    max={maxDescriptionLength}
    selectOptions={countryList}
    bind:company={companyFormValues}
  />
  <Button type="submit" kind="primary" on:click={handleSubmit}>
    {$_('registration.next')}
  </Button>
</div>
