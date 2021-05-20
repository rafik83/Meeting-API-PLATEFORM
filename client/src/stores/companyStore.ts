import type { Company } from '../domain';
import { writable } from 'svelte/store';

const createSelectedCompany = () => {
  const defaultValue: Company = {
    name: '',
    countryCode: '',
    website: '',
    activity: '',
  };

  const { subscribe, update } = writable({
    companyData: defaultValue,
    isCreation: true,
  });

  return {
    subscribe,
    updateCompanyData: (company: Company) => {
      update((companyStoreData) => ({
        ...companyStoreData,
        companyData: company,
      }));
    },
    resetCompanyData: () => {
      update((companyStoreData) => ({
        ...companyStoreData,
        companyData: defaultValue,
      }));
    },
    updateStatus: (isCreation: boolean) => {
      update((companyStoreData) => ({ ...companyStoreData, isCreation }));
    },
  };
};

export const selectedCompanyStore = createSelectedCompany();
