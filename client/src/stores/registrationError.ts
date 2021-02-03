import { writable } from 'svelte/store';

type Error = {
  hasError: boolean;
  message?: string;
};

const defaultValue = {
  hasError: false,
};

export const errorStore = writable<Error>(defaultValue);

export const addError = (errorMessage: string) => {
  errorStore.set({
    hasError: true,
    message: errorMessage,
  });
};

export const discardError = () => {
  errorStore.update((item) => {
    return {
      message: item.message,
      hasError: false,
    };
  });
};
