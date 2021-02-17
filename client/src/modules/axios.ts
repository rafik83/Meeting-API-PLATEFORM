import axios, { AxiosRequestConfig } from 'axios';
import config from '../config';

const client = axios.create({
  baseURL: config.API_URL,
  withCredentials: true,
  headers: {
    Accept: 'application/json',
  },
});

export const post = <T, R>(url: string, payload: T) => {
  return client.post<R>(url, payload, { withCredentials: true });
};

export const put = <T>(url: string, payload: T) => {
  return client.put(url, payload);
};

export const patch = <T, R>(
  url: string,
  payload: T,
  config: AxiosRequestConfig
) => {
  return client.patch<R>(url, payload, config);
};

export const del = (url: string) => {
  return client.delete(url);
};

export const get = async <T>(url: string, withCredentials: boolean = false) => {
  return client.get<T>(url, { withCredentials });
};
