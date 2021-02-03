import type { User } from '../domain';
import { getFakeAxiosResponse } from '../__fixtures__/axios';
import { getUserIdFromLocation, mapToUser } from './account';

describe('Account Repository', () => {
  it('should transmform an axios response to User', () => {
    const email = 'foo.bar@com.com';
    const firstName = 'lol';
    const lastName = 'ypop';
    const id = 3333;
    const user = {
      email,
      firstName,
      lastName,
      id,
    };

    const axiosResponse = getFakeAxiosResponse<User>(user);

    expect(mapToUser(axiosResponse)).toEqual(user);
  });

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
