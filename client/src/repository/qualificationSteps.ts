import type { QualificationStep } from '../domain';
import { get } from '../modules/axios';

export const orderByPosition = (
  qualificationSteps: Array<QualificationStep>
) => {
  return qualificationSteps.sort((a, b) => a.position - b.position);
};
export const getAllQualificationSteps = async (communityId: number) => {
  const qualificationSteps = (
    await get<Array<QualificationStep>>(`/${communityId}/steps`)
  ).data;

  return orderByPosition(qualificationSteps);
};
