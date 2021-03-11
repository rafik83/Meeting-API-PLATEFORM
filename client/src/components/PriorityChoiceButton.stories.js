import PriorityChoiceButton from './PriorityChoiceButton.svelte';

const defaultProps = {
  name: 'myTag',
  priority: null,
  id: 666,
  displayPriority: true,
};

export default {
  title: 'Vimeet365/PriorityChoiceButton',
  component: PriorityChoiceButton,
  args: defaultProps,
};

const Template = ({ ...args }) => ({
  Component: PriorityChoiceButton,
  props: args,
});

export const base = Template.bind({});

export const selected = Template.bind({});

selected.args = {
  ...base.args,
  priority: 10,
};

export const selectedWithNoPriority = Template.bind({});

selectedWithNoPriority.args = {
  ...base.args,
  displayPriority: false,
  priority: 10,
};
