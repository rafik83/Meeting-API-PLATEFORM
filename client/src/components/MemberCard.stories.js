import MemberCard from './MemberCard.svelte';
import { buildFakeTag } from '../__fixtures__/FakeTags';

export default {
  title: 'Vimeet365/MemberCard',
  component: MemberCard,
  args: {
    account: {
      firstName: 'John',
      lastName: 'Doe',
      jobPosition: 'CTO & CEO',
      company: 'Greatest Company',
      languages: ['fr', 'en'],
    },
    url:
      'https://vivrelibredotblog.files.wordpress.com/2018/01/le-fond-et-la-forme.png',
    isOnline: false,
    matchingPourcentage: 89,
    tags: [
      buildFakeTag({ name: 'BUY PLANES' }),
      buildFakeTag({ name: 'FIND INDUSTRIAL PARTNERS' }),
      buildFakeTag({ name: 'Blue and white optics' }),
      buildFakeTag({ name: 'Dangerous optoelectronics' }),
      buildFakeTag({
        name: 'Methods and Processes for Product Assurance of EEE Components',
      }),
    ],
  },
};

const Template = ({ ...args }) => ({
  Component: MemberCard,
  props: args,
});

export const Default = Template.bind({});
