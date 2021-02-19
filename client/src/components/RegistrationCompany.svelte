<script>
  import { _ } from 'svelte-i18n';
  import * as yup from 'yup';
  import { extractErrors } from '../modules/validator';

  import DragAndDrop from './DragAndDrop.svelte';
  import CompanyForm from './CompanyForm.svelte';
  import { getFileUploadReport } from '../modules/fileManagement';

  let accept = ['image/jpg', 'image/jpeg', 'image/png'];
  let maxSize = 1 * 1024 * 1024; // 1Mb
  let dragAndDropName = 'Company logo';
  import FormSubmit from './FormSubmit.svelte';

  // Mocked values
  export let maxDescription = 30;
  export let options = [
    { id: 'en', name: 'Royaume-uni' },
    { id: 'fr', name: 'France' },
  ];

  // Return values
  export let compagnyFormValues;

  let errors = {};

  const validationSchema = yup.object().shape({
    compagnyName: yup.string().required($_('validation.field_required')),
    selectedLocale: yup.string().required($_('validation.field_required')),
    compagnyWebsite: yup
      .string()
      .required($_('validation.field_required'))
      .url($_('validation.wrong_url')),
    compagnyDescription: yup
      .string()
      .max(
        maxDescription,
        $_('validation.maximum_characters', { value: maxDescription })
      ),
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await validationSchema.validate(compagnyFormValues, {
        abortEarly: false,
      });
      errors = {};
      console.log(compagnyFormValues);

      // onSubmitForm(compagnyFormValues);
    } catch (err) {
      errors = extractErrors(err);
    }
  };
</script>

<!-- 
    - recupérer LE fichier upload
    - recuperer les valeurs de company form
    - validerr si les champs du company form sont ok
    -> si tout est ok passer les fichiers et les valeurs du formulaire à la page (index.svelte)
 -->

<DragAndDrop
  {accept}
  {maxSize}
  name={dragAndDropName}
  validateFiles={getFileUploadReport}
/>
<form>
  <CompanyForm
    {errors}
    max={maxDescription}
    {options}
    bind:submittedValues={compagnyFormValues}
  />
  <FormSubmit value={$_('registration.next')} on:click={handleSubmit} />
</form>
