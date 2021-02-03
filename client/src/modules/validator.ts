import type { ValidationError } from 'yup';
import registrationSteps from '../constants';

export const extractErrors = (
  err: ValidationError
): { [path: string]: string } => {
  return err.inner.reduce((acc, err) => {
    return { ...acc, [err.path]: err.message };
  }, {});
};

export const isValidRegistrationStep = (step: string): boolean => {
  return (
    Object.keys(registrationSteps).findIndex(
      (item) => registrationSteps[item] === step
    ) !== -1
  );
};
