import MainObjectiveTagsNavigator from './MainObjectiveTagsNavigator.svelte';
import {buildFakeTag} from "../__fixtures__/FakeTags";

const defaultProps = {
    tags: [
        buildFakeTag({name: 'Satelltte'}),
        buildFakeTag({name: 'Space Apps'}),
        buildFakeTag({name: 'Ground'}),
    ]
};

export default {
    title: 'Vimeet365/MainObjectiveTagsNavigator',
    component: MainObjectiveTagsNavigator,
    args: defaultProps,
};

const Template = ({ ...args }) => ({
    Component: MainObjectiveTagsNavigator,
    props: args,
});

export const base = Template.bind({});
