<script>
  import CheckBox from './CheckBox.svelte';
  import { secondaryGoals } from '../stores/secondaryGoalsStore';

  export let dataSource;

  export let depth = 0;
  export let max = null;

  const handleChecked = (event, treeItem) => {
    const canAddOneTag = () => {
      if (event.target.checked) {
        if (max && $secondaryGoals.length > max) {
          return false;
        }

        return true;
      }

      return false;
    };

    if (canAddOneTag()) {
      if (!$secondaryGoals.some((item) => item.id === treeItem.tag.id)) {
        $secondaryGoals = [...$secondaryGoals, treeItem.tag];
      }
    } else {
      $secondaryGoals = $secondaryGoals.filter(
        (currentTag) => treeItem.tag.id !== currentTag.id
      );
    }

    if (treeItem.children) {
      treeItem.children.forEach((childNode) => {
        if (canAddOneTag()) {
          if (!$secondaryGoals.some((item) => item.id === childNode.tag.id)) {
            $secondaryGoals = [...$secondaryGoals, childNode.tag];
          }
        } else {
          $secondaryGoals = $secondaryGoals.filter(
            (currentTag) => childNode.tag.id !== currentTag.id
          );
        }
      });
    }
  };
</script>

<div class={depth === 0 ? 'md:col-count-2' : ''}>
  {#each dataSource.children as node (node.tag.id)}
    <div class={depth === 0 ? 'pt-6 mb-6 bi-avoid' : 'my-2'}>
      <CheckBox
        id={`treeSelect-${node.tag.id}`}
        label={node.tag.name}
        labelClass={depth === 0
          ? 'font-bold uppercase text-community-300'
          : 'text-gray-400'}
        checked={$secondaryGoals.some((tag) => node.tag.id === tag.id)}
        on:change={(event) => handleChecked(event, node)}
      />
      {#if node.children}
        <div class="ml-8">
          <svelte:self dataSource={node} depth={depth + 1} />
        </div>
      {/if}
    </div>
  {/each}
</div>
