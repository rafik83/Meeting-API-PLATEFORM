import { buildFakeQualificationStep } from '../__fixtures__/FakeQualificationSteps';
import {
  buildFakeNomenclatureTag,
  buildFakeTag,
} from '../__fixtures__/FakeTags';
import { buildFakeUser } from '../__fixtures__/FakeUser';
import TagSelector from './TagSelector.svelte';

const { min, max, nomenclature, title } = buildFakeQualificationStep({
  minTagCount: 1,
  maxTagCount: 1,
  title: 'A very nice title for this step',
});

const defaultProps = {
  min,
  max,
  nomenclatureTags: nomenclature.tags,
  title,
  user: buildFakeUser({}),
};

export default {
  title: 'Vimeet365/TagSelector',
  component: TagSelector,
  args: defaultProps,
  argTypes: { onNext: { action: 'clicked' } },
};

const Template = ({ ...args }) => ({
  Component: TagSelector,
  props: args,
});

export const base = Template.bind({});

const fakeTag1 = buildFakeTag({ name: 'tag1', id: 1, priority: null });
const fakeTag2 = buildFakeTag({ name: 'tag2', id: 2, priority: null });
const fakeTag3 = buildFakeTag({ name: 'tag3', id: 3, priority: null });
const fakeTag4 = buildFakeTag({ name: 'tag4', id: 4, priority: null });

const qualificationStep2 = buildFakeQualificationStep({
  minTagCount: 1,
  maxTagCount: 33,
  title: 'A very nice title for this step',

  nomenclatureTags: [
    buildFakeNomenclatureTag(fakeTag1),
    buildFakeNomenclatureTag(fakeTag2),
    buildFakeNomenclatureTag(fakeTag3),
    buildFakeNomenclatureTag(fakeTag4),
  ],
});

export const withAMinimumOfTagRequired = Template.bind({});

withAMinimumOfTagRequired.args = {
  ...base.args,
  min: qualificationStep2.min,
  max: qualificationStep2.max,
  nomenclatureTags: qualificationStep2.nomenclature.tags,
};

export const withoutMinimum = Template.bind({});

withoutMinimum.args = {
  ...withAMinimumOfTagRequired.args,
  min: 1,
  max: null,
  title: '',
  nomenclatureTags: qualificationStep2.nomenclature.tags,
};

export const withTitle = Template.bind({});

withTitle.args = {
  ...withAMinimumOfTagRequired.args,
  min: 1,
  title: 'A nice title',
  description: 'A nice description',
  nomenclatureTags: qualificationStep2.nomenclature.tags,
};

export const Errored = Template.bind({});

Errored.args = {
  ...base.args,
  errorMessage: 'Oupsy an error',
};
