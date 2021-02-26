import type { Company, User } from '../domain';
import { post } from '../modules/axios';

export const createCompany = async (
  company: Company,
  userId: number
): Promise<User> => {
  return (await post<Company, User>(`/accounts/${userId}/company`, company))
    .data;
};

export const uploadCompanyLogo = async (
  companyLogo: File,
  companyId: number
) => {
  const formData = new FormData();
  formData.append('logo', companyLogo);
  await post<FormData, void>(`companies/${companyId}/logo`, formData);
};
