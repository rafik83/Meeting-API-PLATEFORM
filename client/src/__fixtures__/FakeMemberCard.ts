import type { User, Tag } from '../domain';
import { buildFakeTag } from './FakeTags';
import { buildFakeUser } from './FakeUser';

type MemberCard = {
  account: User;
  url: string;
  isOnline: boolean;
  matchingPourcentage: number;
  tags: Array<Tag>;
};

export const buildFakeMemberCard = (): MemberCard => {
  return {
    account: buildFakeUser({}),
    url: 'https://www.fillmurray.com/200/200',
    isOnline: Math.round(Math.random()) ? true : false,
    matchingPourcentage: Math.floor(Math.random() * 100),
    tags: [
      buildFakeTag({ name: 'kiwi' }),
      buildFakeTag({ name: 'banane' }),
      buildFakeTag({ name: 'oranges' }),
      buildFakeTag({ name: 'tomates' }),
      buildFakeTag({ name: 'butternut' }),
    ],
  };
};

export const buildFakeMemberCards = (
  numberOfCards: number = 20
): Array<MemberCard> => {
  let memberList = [];
  for (let i = 0; i < numberOfCards; i++) {
    memberList.push(buildFakeMemberCard());
  }

  return memberList;
};
