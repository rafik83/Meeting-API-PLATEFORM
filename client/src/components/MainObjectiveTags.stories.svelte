<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import { buildFakeTag } from '../__fixtures__/FakeTags';
  import MainObjectiveTags from './MainObjectiveTags.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';
  const defaultProps = {
    tags: [
      buildFakeTag({ id: 666, name: 'Tag1' }),
      buildFakeTag({ id: 667, name: 'Tag2' }),
      buildFakeTag({ id: 668, name: 'Tag3' }),
    ],
    titleTag: buildFakeTag({ id: 667, name: 'Title' }),
  };

  const handleOnClick = (e) => {
    alert(`Clicked on tag with name ${e.detail.name}`);
  };
</script>

<Meta
  title="Vimeet365/MainObjectiveTags"
  component={MainObjectiveTags}
  argTypes={{
    highlight: { control: 'boolean' },
  }}
  parameters={defaultProps}
  decorators={[
    (storyFn) => {
      const story = storyFn();
      return {
        Component: PreviewDecorator,
        props: {
          child: story.Component,
          props: story.props,
        },
      };
    },
  ]}
/>

<Template let:args>
  <MainObjectiveTags on:click={handleOnClick} {...args} />
</Template>

<Story name="Normal" args={{ ...defaultProps }} />
