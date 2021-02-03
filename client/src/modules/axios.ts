import axios from 'axios';
import config from '../config';

const client = axios.create({
  baseURL: config.API_URL,
  withCredentials: true,
  headers: {
    Accept: 'application/json',
  },
});

export const post = <T>(
  url: string,
  payload: T,
  withCredentials: boolean = false
) => {
  return client.post(url, payload, { withCredentials });
};

export const put = <T>(url: string, payload: T) => {
  return client.put(url, payload);
};

export const del = (url: string) => {
  return client.delete(url);
};

export const get = async (url: string, withCredentials: boolean = false) => {
  return client.get(url, { withCredentials });
};
