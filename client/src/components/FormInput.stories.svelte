<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import PreviewDecorator from './PreviewDecorator.svelte';
  import FormInput from './FormInput.svelte';
  const defaultProps = {
    name: 'input_name',
    type: 'text',
    label: 'first name',
    value: '',
  };
</script>

<Meta title="Vimeet365/FormInput" args={defaultProps} component={FormInput} />

<Template
  let:args
  decorators={[
    (storyFun) => {
      const story = storyFun();
      return {
        Component: PreviewDecorator,
        props: {
          child: story.Component,
          props: story.props,
        },
      };
    },
  ]}
>
  <FormInput {...args} />
</Template>

<Story name="Text" />
<Story
  name="Email"
  args={{
    ...defaultProps,
    type: 'email',
  }}
/>
<Story
  name="password"
  args={{
    ...defaultProps,
    type: 'password',
  }}
/>
<Story
  name="Errored"
  args={{
    ...defaultProps,
    type: 'text',
    errorMessage: 'A real error',
  }}
/>
<Story
  name="WithPreffiledValue"
  args={{
    ...defaultProps,
    value: 'niceValue',
  }}
/>

<Story
  name="loading"
  args={{
    ...defaultProps,
    loading: true,
  }}
/>
