import type { Tag, Member } from '../domain';
import { patch, post } from '../modules/axios';

type CreateMemberPayload = {
  community: number;
};

export const createMember = async (communityId: number): Promise<Member> => {
  const reponse = await post<CreateMemberPayload, Member>('/members', {
    community: communityId,
  });

  return reponse.data;
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
