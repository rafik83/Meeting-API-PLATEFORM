import type { ValidationError } from 'yup';

export const extractErrors = (
  err: ValidationError
): { [path: string]: string } => {
  return err.inner.reduce((acc, err) => {
    return { ...acc, [err.path]: err.message };
  }, {});
};
