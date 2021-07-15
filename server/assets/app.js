import './styles/app.css';
import './bootstrap';

import MatchingBetweenGoals from './components/MatchingBetweenGoals';
import WysiwigEditor from './components/WysiwigEditor';
import Collection from './components/Collection';

const refineGoalsContainer = document.querySelector(
  '#refine_goal_refinedGoals'
);

const matchingGoalsContainer = document.querySelector(
  '#goal_matchings_matchingTags'
);

if (refineGoalsContainer) {
  new Collection(refineGoalsContainer);
}

if (matchingGoalsContainer) {
  new MatchingBetweenGoals(matchingGoalsContainer);
}

document
  .querySelectorAll('[data-quill]')
  .forEach((node) => new WysiwigEditor(node));

const cardListTags = document.querySelector('#card_list_tags');
if (cardListTags) {
  const cardListTagsCollection = new Collection(cardListTags);
  cardListTagsCollection();
}
