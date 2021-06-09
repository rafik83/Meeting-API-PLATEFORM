<script>
  import { Meta, Template, Story } from '@storybook/addon-svelte-csf';
  import { buildFakeMemberCard } from '../__fixtures__/FakeCards';
  import MemberCard from './MemberCard.svelte';
  import PreviewDecorator from './PreviewDecorator.svelte';

  const defaultProps = {
    ...buildFakeMemberCard(),
  };

  const handleViewProfile = (e) => {
    alert(`So you want check ${e.detail.firstName}'s profile ?`);
  };

  const handleMeetMember = (e) => {
    alert(`So you want meet  ${e.detail.firstName} ?`);
  };
</script>

<Meta
  title="Vimeet365/MemberCard"
  component={MemberCard}
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
  <MemberCard
    on:view_member_profile={handleViewProfile}
    on:meet_member={handleMeetMember}
    {...args}
  />
</Template>

<Story name="Normal" args={{ ...defaultProps }} />
<Story name="Without Picture" args={{ ...defaultProps, picture: null }} />
