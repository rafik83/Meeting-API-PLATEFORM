export const store = (key: string, value: string) => {
  if (typeof window === 'undefined') {
    return undefined;
  }
  localStorage.setItem(key, value);
};

export const getItemFromKey = (key: string) => {
  if (typeof window === 'undefined') {
    return undefined;
  }
  return localStorage.getItem(key);
};
