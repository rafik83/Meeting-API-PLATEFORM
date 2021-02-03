import type { AxiosResponse } from 'axios';

export const getFakeAxiosResponse = <T>(data: T): AxiosResponse => {
  return {
    data: { ...data },
    status: 200,
    config: {},
    statusText: '',
    headers: {},
  };
};
