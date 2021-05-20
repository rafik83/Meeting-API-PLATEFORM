import { registrationSteps } from '../constants';
import { isValidRegistrationStep, isCompanyValid } from './validator';
import { buildFakeCompany } from '../__fixtures__/FakeCompany';

describe('validator', () => {
  describe('isValidRegistrationStep', () => {
    it('should return true if the given step is valid', () => {
      const step = registrationSteps.SIGN_IN;

      expect(isValidRegistrationStep(step)).toBeTruthy();
    });

    it('should return false if the given step is valid', () => {
      const step = 'not_valid';

      expect(isValidRegistrationStep(step)).toBeFalsy();
    });
  });

  describe('isCompanyValid', () => {
    it('should return nothing if the given company is valid', async () => {
      const company = buildFakeCompany({});

      const result = await isCompanyValid(company);
      expect(result).toBe(undefined);
    });

    it('should return an error report if the given company is NOT valid', async () => {
      const company = {
        name: 'yolo',
      };

      const result = await isCompanyValid(company);
      expect(result).toEqual({
        countryCode: 'validation.field_required',
        website: 'validation.field_required',
      });
    });
  });
});
