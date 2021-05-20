import type { ValidationError } from 'yup';
import { registrationSteps } from '../constants';
import type { Company } from '../domain';
import * as yup from 'yup';

type ExtractedErrors = { [path: string]: string };

export const extractErrors = (err: ValidationError): ExtractedErrors => {
  if (err.inner) {
    return err.inner.reduce((acc, err) => {
      return { ...acc, [err.path]: err.message };
    }, {});
  } else {
    console.error(err);
    return {};
  }
};

export const isValidRegistrationStep = (step: string): boolean => {
  return (
    Object.keys(registrationSteps).findIndex(
      (item) => registrationSteps[item] === step
    ) !== -1
  );
};

export const isCompanyValid = async (
  company: Partial<Company>
): Promise<ExtractedErrors | void> => {
  let result: ExtractedErrors | void;

  const validationSchema = yup.object().shape({
    name: yup.string().required('validation.field_required'),
    countryCode: yup.string().required('validation.field_required').nullable(),
    website: yup
      .string()
      .url('validation.wrong_url')
      .required('validation.field_required'),
    activity: yup.string().max(3000, 'validation.maximum_characters'),
  });

  try {
    await validationSchema.validate(company, { abortEarly: false });
  } catch (error) {
    result = extractErrors(error);
  }

  return result;
};
