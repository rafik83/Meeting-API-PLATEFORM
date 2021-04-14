import { buildFakeUser } from '../__fixtures__/FakeUser';
import { getUserIdFromLocation, getUserMemberIdInCommunity } from './account';

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

  it('should return an id if user is part of a given community', () => {
    const communityId = 666;
    const memberId = 333;
    const fakUser = buildFakeUser({
      members: [
        {
          id: memberId,
          joinedAt: new Date(),
          community: communityId,
        },
        {
          id: 444,
          joinedAt: new Date(),
          community: communityId,
        },
      ],
    });
    const result = getUserMemberIdInCommunity(fakUser, communityId);
    expect(result).toBe(memberId);
    expect(result).not.toBe(444);
  });

  it('should return null if user is NOT part of a given community', () => {
    const communityId = 666;
    const memberId = 333;
    const fakUser = buildFakeUser({
      members: [
        {
          id: memberId,
          joinedAt: new Date(),
          community: 333,
        },
        {
          id: 444,
          joinedAt: new Date(),
          community: 8888,
        },
      ],
    });
    const result = getUserMemberIdInCommunity(fakUser, communityId);
    expect(result).toBe(null);
  });
});
