import type { Credentials, User } from '../domain';
import { get, patch, post, put } from '../modules/axios';

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
  credentials: Credentials
): Promise<number> => {
  const { headers } = await post<Credentials, void>('/login', credentials);
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

export const updateUserCompany = async (
  userId: number,
  companyId: number
): Promise<User> => {
  return (
    await put<{ company: number }>(`accounts/${userId}/company`, {
      company: companyId,
    })
  ).data;
};

export const requestAccountValidationEmail = async (
  userId: number
): Promise<void> => {
  await get<void>(`/accounts/${userId}/validation`, {
    headers: {
      origin: window.location.hostname,
    },
  });
};

export const checkToken = async (
  userId: number,
  token: string
): Promise<void> => {
  await post<
    {
      token: string;
    },
    void
  >(
    `/accounts/${userId}/validation`,
    { token },
    {
      headers: {
        origin: window.location.hostname,
      },
    }
  );
};
