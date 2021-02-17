import { orderByPosition } from './qualificationSteps';
import { buildFakeQualificationStep } from '../__fixtures__/FakeQualificationSteps';

describe('QualificationStep Repository', () => {
  describe('orderqualification steps by position', () => {
    it('should returnqualification steps ordered by position', () => {
      const steps4 = buildFakeQualificationStep({ position: 4 });
      const steps2 = buildFakeQualificationStep({ position: 2 });
      const steps6 = buildFakeQualificationStep({ position: 6 });

      const qualificationSteps = [steps4, steps2, steps6];
      const expectedValues = [steps2, steps4, steps6];

      expect(orderByPosition(qualificationSteps)).toStrictEqual(expectedValues);
    });

    it('should returnqualification steps ordered by position -- onequalification step case', () => {
      const steps4 = buildFakeQualificationStep({ position: 4 });

      const qualificationSteps = [steps4];
      const expectedValues = [steps4];

      expect(orderByPosition(qualificationSteps)).toStrictEqual(expectedValues);
    });

    it('should returnqualification steps ordered by position --many item with same position', () => {
      const steps4 = buildFakeQualificationStep({ position: 1 });
      const steps2 = buildFakeQualificationStep({ position: 1 });
      const steps6 = buildFakeQualificationStep({ position: 2 });

      const qualificationSteps = [steps4, steps2, steps6];
      const expectedResult = [steps4, steps2, steps6];

      expect(orderByPosition(qualificationSteps)).toStrictEqual(expectedResult);
    });
  });
});
