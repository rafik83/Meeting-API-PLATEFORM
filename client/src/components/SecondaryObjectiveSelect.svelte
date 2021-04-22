<script>
  import FormTreeSelect from './FormTreeSelect.svelte';
  import SecondaryObjectivesHeader from './SecondaryObjectivesHeader.svelte';

  export let titleTag;
  export let goalTreeItem;
  export let max;
</script>

<div class="flex flex-wrap w-full justify-left pl-7 py-4 items-center mt-4">
  <SecondaryObjectivesHeader id={titleTag.id} text={titleTag.name} />
</div>
<div class="w-full px-10">
  <FormTreeSelect {max} dataSource={goalTreeItem} />
</div>
