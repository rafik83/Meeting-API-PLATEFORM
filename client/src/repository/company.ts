import type { Company, User } from '../domain';
import { post, get } from '../modules/axios';

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

export const getHubspotCompanies = async (
  domain: string,
  limit: number = 10
): Promise<Array<Company>> => {
  return (
    await get<Array<Company>>(
      `hubspot/companies?domain=${domain}&limit=${limit}`
    )
  ).data;
};
