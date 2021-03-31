import ButtonCard from './ButtonCard.svelte';

export default {
    title: 'Vimeet365/ButtonCard',
    component: ButtonCard,
    args: {
        type: 'submit',
        kind: 'primary',
    },
};

const Template = ({ ...args }) => ({
    Component: ButtonCard,
    props: args,
});

export const primary = Template.bind({});
export const community = Template.bind({});
export const action = Template.bind({});

community.args = {
    ...primary.args,
    kind: 'community',
};

action.args = {
    ...primary.args,
    kind: 'action',
};

