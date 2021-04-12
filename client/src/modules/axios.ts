import axios, { AxiosRequestConfig, AxiosInstance } from 'axios';

let apiUrl: string;

const getClient = (): AxiosInstance => {
  return axios.create({
    baseURL: apiUrl,
    withCredentials: true,
    headers: {
      Accept: 'application/json',
    },
  });
};

export const setBaseUrl = (url: string) => {
  // init apiUrl only once, if it's set for SSR, it must not be changed after
  if (!apiUrl) {
    apiUrl = url;
  }
};

export const post = <T, R>(url: string, payload: T) => {
  return getClient().post<R>(url, payload, { withCredentials: true });
};

export const put = <T>(url: string, payload: T) => {
  return getClient().put(url, payload);
};

export const patch = <T, R>(
  url: string,
  payload: T,
  config: AxiosRequestConfig
) => {
  return getClient().patch<R>(url, payload, config);
};

export const del = (url: string) => {
  return getClient().delete(url);
};

export const get = async <T>(url: string, withCredentials: boolean = false) => {
  return getClient().get<T>(url, { withCredentials });
};
