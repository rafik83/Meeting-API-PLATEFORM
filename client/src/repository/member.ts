import type { Tag, Member, MemberGoal } from '../domain';
import { get, patch, post } from '../modules/axios';

type CreateMemberPayload = {
  community: number;
};

export const createMember = async (communityId: number): Promise<Member> => {
  return (
    await post<CreateMemberPayload, Member>('/members', {
      community: communityId,
    })
  ).data;
};

type UpdateMemberPayload = {
  step: number;
  tags: Array<Tag>;
};

export const updateMember = async (
  memberId: number,
  payload: UpdateMemberPayload
): Promise<Member> => {
  const result = await patch<UpdateMemberPayload, Member>(
    `/members/${memberId}`,
    {
      step: payload.step,
      tags: payload.tags,
    },
    {
      headers: {
        'Content-Type': 'application/merge-patch+json',
      },
    }
  );

  return result.data;
};

export type SaveCommunityGoalPayload = {
  goal: number;
  tags: Array<Tag>;
};

export const saveCommunityGoal = async (
  memberId: number,
  data: SaveCommunityGoalPayload
): Promise<void> => {
  await post<SaveCommunityGoalPayload, void>(
    `/members/${memberId}/goals`,
    data
  );
};

export const getMemberGoals = async (
  communityId: number
): Promise<Array<MemberGoal>> => {
  const result = (await get<Array<MemberGoal>>(`/members/${communityId}/goals`))
    .data;

  return result;
};
