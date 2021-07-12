import './styles/app.css';
import './bootstrap';

import RefineGoals from './components/RefineGoals';
import MatchingBetweenGoals from './components/MatchingBetweenGoals';
import WysiwigEditor from './components/WysiwigEditor';

const refineGoalsContainer = document.querySelector(
  '#refine_goal_refinedGoals'
);

const matchingGoalsContainer = document.querySelector(
  '#goal_matchings_matchingTags'
);

if (refineGoalsContainer) {
  new RefineGoals(refineGoalsContainer);
}

if (matchingGoalsContainer) {
  new MatchingBetweenGoals(matchingGoalsContainer);
}

document
  .querySelectorAll('[data-quill]')
  .forEach((node) => new WysiwigEditor(node));
