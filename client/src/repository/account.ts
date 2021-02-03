import type { AxiosResponse } from 'axios';
import type { User, Crendentials } from '../domain';
import { get, post } from '../modules/axios';

export const mapToUser = (axiosResponse: AxiosResponse): User => {
  const { id, lastName, firstName, email } = axiosResponse.data;
  return {
    lastName,
    firstName,
    email,
    id,
  };
};

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
  const { headers } = await post<Crendentials>('/login', credentials);
  if (!headers || !headers.location) {
    throw new Error('No Location header found');
  }

  const userId = getUserIdFromLocation(headers.location);
  if (!userId) {
    throw new Error('No id found in the header');
  }
  return userId;
};

export const findById = async (userId: number): Promise<User> => {
  const response = await get(`/accounts/${userId}`);
  return mapToUser(response);
};

export const register = async (user: User): Promise<User> => {
  const response = await post<User>('/accounts', user);
  return mapToUser(response);
};
