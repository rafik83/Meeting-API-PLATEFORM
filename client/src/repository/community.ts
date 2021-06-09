import type {
  Card,
  CommunityGoal,
  CommunityList as CommunityCardList,
  MemberGoal,
  Tag,
} from '../domain';
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

export const getCommunityLists = async (
  communityId: number
): Promise<Array<CommunityCardList>> => {
  const result = (
    await get<Array<CommunityCardList>>(
      `/communities/${communityId}/card_lists`
    )
  ).data;
  return result;
};

export const getCommunityCards = async (
  communityId: number,
  listId: number
): Promise<Array<Card>> => {
  const result = (
    await get<Array<Card>>(`/communities/${communityId}/lists/${listId}`)
  ).data;

  return result;
};
