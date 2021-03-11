import FormTextarea from './FormTextarea.svelte';

export default {
  title: 'Vimeet365/FormTextarea',
  component: FormTextarea,
  args: {
    max: 30,
    name: 'textarea',
    value: '',
    label: 'Description',
    placeholder: 'Tappez votre text ici',
  },
};

const Template = ({ ...args }) => ({
  Component: FormTextarea,
  props: args,
});

export const Basic = Template.bind({});
export const Error = Template.bind({});
export const WithText = Template.bind({});

Error.args = {
  ...Basic.args,
  errorMessage: 'Error message',
};

WithText.args = {
  ...Basic.args,
  value:
    'Occaecat aliquip proident dolor in id quis ipsum consequat culpa deserunt Lorem sunt.',
};
