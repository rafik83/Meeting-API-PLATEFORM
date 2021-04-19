import type { CommunityGoal, MemberGoal, Tag } from '../domain';
import { get } from '../modules/axios';
import { getTagsFromNomenclature } from '../modules/tagManagement';

type CommunityGoalTags = {
  tags: Array<Tag>;
  min: number;
  max: number;
  goalId: number;
};

export const getCommunityMainObjectives = async (
  communityId: number
): Promise<CommunityGoalTags> => {
  const result = (
    await get<Array<CommunityGoal>>(`/communities/${communityId}/goals`)
  ).data;

  /*
    The main community objective is the one without parent id
   */

  const { nomenclature, min, max, id } = result.find((item) => !item.parent);
  const tags = getTagsFromNomenclature(nomenclature);
  return {
    goalId: id,
    max,
    min,
    tags,
  };
};

export const getCommunityGoals = async (
  communityId: number
): Promise<Array<MemberGoal>> => {
  const result = (
    await get<Array<MemberGoal>>(`/communities/${communityId}/goals`)
  ).data;
  return result;
};
