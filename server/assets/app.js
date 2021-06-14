import './styles/app.css';
import './bootstrap';

import RefineGoals from "./components/RefineGoals";
import MatchingBetweenGoals from "./components/MatchingBetweenGoals";

const refineGoalsContainer = document.querySelector('#refine_goal_refinedGoals');
if (refineGoalsContainer) {
    new RefineGoals(refineGoalsContainer);
}

const matchingGoalsContainer = document.querySelector('#goal_matchings_matchingTags');
if (matchingGoalsContainer) {
    new MatchingBetweenGoals(matchingGoalsContainer);
}
