import './styles/app.css';
import './bootstrap';

import RefineGoals from './components/RefineGoals';
import MatchingBetweenGoals from './components/MatchingBetweenGoals';

const refineGoalsContainer = document.querySelector(
  '#refine_goal_refinedGoals'
);

const matchingGoalsContainer = document.querySelector(
  '#goal_matchings_matchingTags'
);

if (refineGoalsContainer) {
  const refineMailGoal = new RefineGoals(refineGoalsContainer);

  refineMailGoal();
}

if (matchingGoalsContainer) {
  const matching = new MatchingBetweenGoals(matchingGoalsContainer);
  matching();
}
