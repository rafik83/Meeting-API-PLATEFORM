import './styles/app.scss';

import './bootstrap';

import { Collapsible, Drop, Tree, MobileSidebar } from '@elao/admin';
import RefineGoals from "./components/RefineGoals";
import MatchingBetweenGoals from "./components/MatchingBetweenGoals";

Collapsible.init();
Drop.init();
Tree.init();
MobileSidebar.init();

const refineGoalsContainer = document.querySelector('#refine_goal_refinedGoals');
if (refineGoalsContainer) {
    new RefineGoals(refineGoalsContainer);
}

const matchingGoalsContainer = document.querySelector('#goal_matchings_matchingTags');
if (matchingGoalsContainer) {
    new MatchingBetweenGoals(matchingGoalsContainer);
}
