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

export const authenticate = async (
  credentials: Crendentials
): Promise<AxiosResponse> => {
  return post<Crendentials>('/login', credentials);
};

export const findById = async (userId: number): Promise<User> => {
  const response = await get(`/accounts/${userId}`);
  return mapToUser(response);
};
