import type { User, Crendentials } from '../domain';
import { get, post, patch } from '../modules/axios';

export const getUserIdFromLocation = (
  locationHeader: string
): number | void => {
  const parsedInt = parseInt(locationHeader.split('/')[3], 10);
  if (isNaN(parsedInt)) {
    return null;
  }
  return parsedInt;
};

export const authenticate = async (
  credentials: Crendentials
): Promise<number> => {
  const { headers } = await post<Crendentials, void>('/login', credentials);
  if (!headers || !headers.location) {
    throw new Error('No Location header found');
  }
  const userId = getUserIdFromLocation(headers.location);
  if (!userId) {
    throw new Error('No id found in the header');
  }
  return userId;
};

export const getUserMemberIdInCommunity = (
  user: User,
  communityId: number
): number | null => {
  const member = user.members.find(
    (member) => member.community === communityId
  );
  if (!member) {
    return null;
  }
  return member.id;
};

export const findById = async (userId: number): Promise<User> => {
  return (await get<User>(`/accounts/${userId}`)).data;
};

export const register = async (user: User): Promise<User> => {
  return (await post<User, User>('/accounts', user)).data;
};
export const uploadAvatar = async (accountAvatar: File, userId: number) => {
  const formData = new FormData();
  formData.append('file', accountAvatar);
  await post<FormData, void>(`accounts/${userId}/avatar`, formData);
};

type AddAccountPersonalData = {
  jobPosition: string;
  country: string;
  timezone: string;
  languages: Array<string>;
  jobTitle: string;
};

export const updateProfile = async (
  userId: number,
  payload: AddAccountPersonalData
): Promise<void> => {
  await patch<AddAccountPersonalData, void>(
    `/accounts/${userId}/profile`,
    payload,
    {
      headers: {
        'Content-Type': 'application/merge-patch+json',
      },
    }
  );
};
