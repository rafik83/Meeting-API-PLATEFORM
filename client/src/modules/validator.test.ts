import registrationSteps from '../constants';
import { isValidRegistrationStep } from './validator';

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
});
