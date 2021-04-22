<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import { buildFakeTag } from '../__fixtures__/FakeTags';
  import { buildFakeTreeItem } from '../__fixtures__/TreeItem';
  import FormTreeSelect from './FormTreeSelect.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';

  const GroundTag = buildFakeTag({
    name: 'Ground',
    id: 1,
  });
  const SatelliteTag = buildFakeTag({
    name: 'Satellite',
    id: 2,
    parent: GroundTag,
  });

  const SpacecraftPowerTag = buildFakeTag({
    name: 'SpacecraftPower',
    id: 3,
    parent: GroundTag,
  });

  const OpticsTag = buildFakeTag({
    name: 'Optics',
    id: 4,
    parent: SatelliteTag,
  });

  const ElectronicsTag = buildFakeTag({
    name: 'Electronics',
    id: 5,
    parent: SatelliteTag,
  });

  const TurbineTag = buildFakeTag({
    name: 'Turbine',
    id: 6,
    parent: SpacecraftPowerTag,
  });

  const PistonTag = buildFakeTag({
    name: 'Piston',
    id: 7,
    parent: SpacecraftPowerTag,
  });

  /* The tree looks like this tree :
   *
   *            Ground
   *            │    │
   *            │    └──────────────┐
   *            │                   │
   *            ▼                   ▼
   *    Satellite          Spacecraft Power
   *   ┌───┘ └───┐ *        ┌───┘ └───┐
   *   ▼         ▼          ▼         ▼
   * Optics    Electronics  Turbine   Piston
   */

  const PistonTreeItem = buildFakeTreeItem({
    tag: PistonTag,
    parent: SpacecraftPowerTag,
    children: [],
  });
  const TurbineTreeItem = buildFakeTreeItem({
    tag: TurbineTag,
    parent: SpacecraftPowerTag,
  });

  const spaceCraftTreeItem = buildFakeTreeItem({
    tag: SpacecraftPowerTag,
    parent: GroundTag,
    children: [PistonTreeItem, TurbineTreeItem],
  });

  const opticTreeItem = buildFakeTreeItem({
    tag: OpticsTag,
    parent: SatelliteTag,
  });

  const ElectronicTreeItem = buildFakeTreeItem({
    tag: ElectronicsTag,
    parent: SatelliteTag,
  });

  const SatelliteTreeItem = buildFakeTreeItem({
    tag: SatelliteTag,
    parent: GroundTag,
    children: [opticTreeItem, ElectronicTreeItem],
  });

  const GroundTreeItem = buildFakeTreeItem({
    tag: GroundTag,
    parent: null,
    children: [SatelliteTreeItem, spaceCraftTreeItem],
  });

  const defaultProps = {
    dataSource: GroundTreeItem,
  };

  const handleOnClick = (e) => {
    alert(`Clicked on tag with name ${e.detail.name}`);
  };
</script>

<Meta
  title="Vimeet365/FormTreeSelect"
  component={FormTreeSelect}
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
  <FormTreeSelect on:click={handleOnClick} {...args} />
</Template>

<Story name="oneTreeItemWithNLevel" args={{ ...defaultProps }} />
