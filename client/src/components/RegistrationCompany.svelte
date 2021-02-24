<script>
  import DragAndDrop from './DragAndDrop.svelte';
  import CompanyForm from './CompanyForm.svelte';
  import { getFileUploadReport } from '../modules/fileManagement';

  let accept = ['image/jpg', 'image/jpeg', 'image/png'];
  let maxSize = 1 * 1024 * 1024; // 1Mb
  let dragAndDropName = 'Company logo';
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
<CompanyForm />
