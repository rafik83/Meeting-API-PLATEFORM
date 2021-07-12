<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import CompanyCard from './CompanyCard.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';

  const defaultProps = {
    name: 'Evil Corp',
    picture:
      'https://vivrelibredotblog.files.wordpress.com/2018/01/le-fond-et-la-forme.png',
    activity: 'A nice activity for a nice company in a nice country',
  };

  const handleGenerateNewLeads = () => {
    alert('New lead generated');
  };
</script>

<Meta
  title="Vimeet365/CompanyCard"
  component={CompanyCard}
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
  <CompanyCard on:generate_new_leads={handleGenerateNewLeads} {...args} />
</Template>

<Story name="Basic" args={{ ...defaultProps }} />
<Story name="Without Picture" args={{ ...defaultProps, picture: null }} />
