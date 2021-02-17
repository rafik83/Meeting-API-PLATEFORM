import { getUserIdFromLocation } from './account';

describe('Account Repository', () => {
  it('should return the id from the location header', () => {
    const locationHeader = '/api/tourte/55';
    const result = getUserIdFromLocation(locationHeader);
    expect(result).toBe(55);
  });

  it('should return null if nod id found in the location header', () => {
    const locationHeader = '/api/tourte/dummy';
    const result = getUserIdFromLocation(locationHeader);
    expect(result).toBe(null);
  });
});
