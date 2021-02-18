<script>
  import DragAndDrop from './DragAndDrop.svelte';
  import CompanyForm from './CompanyForm.svelte';
  export let toto;
</script>

<!-- 
    - recupérer LE fichier upload
    - recuperer les valeurs de company form
    - validerr si les champs du company form sont ok
    -> si tout est ok passer les fichiers et les valeurs du formulaire à la page (index.svelte)
 -->

<DragAndDrop />
<CompanyForm {toto} />
