import type { User } from '../domain';
import { getFakeAxiosResponse } from '../__fixtures__/axios';
import { mapToUser } from './account';

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
});
