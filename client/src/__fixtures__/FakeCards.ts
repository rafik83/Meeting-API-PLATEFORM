import { CARD_KIND } from '../constants';
import type { CompanyCard, MemberCard, EventCard } from '../domain';
import { buildFakeTag } from './FakeTags';

export const buildFakeMemberCard = (): MemberCard => {
  return {
    companyName: 'Evil Corp.',
    firstName: 'John',
    lastName: 'Doe',
    id: 666,
    picture: 'https://www.traficantes.net/sites/default/files/kropotkin.jpg',
    kind: 'member',
    languageCodes: ['FR', 'EN'],
    jobPosition: 'Papa',
    mainGoal: buildFakeTag({ name: 'kiwi' }),
    secondaryGoal: buildFakeTag({ name: 'gouda' }),
    goals: [
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

export const buildFakeCompanyCard = (): CompanyCard => {
  return {
    kind: CARD_KIND.company,
    id: 333,
    picture:
      'https://vivrelibredotblog.files.wordpress.com/2018/01/le-fond-et-la-forme.png',
    name: 'SpaceX',
    activity: 'Un joli texte de description',
  };
};

export const buildFakeEventCard = (): EventCard => {
  return {
    picture:
      'https://vivrelibredotblog.files.wordpress.com/2018/01/le-fond-et-la-forme.png',
    name: 'World Event',
    startDate: '2021-06-11T12:38:39.755Z',
    endDate: '2021-06-13T12:38:39.755Z',
    eventType: 'online',
    registerUrl: 'https://hello.world',
    findOutMoreUrl: 'https://find_out_more.com',
    tags: [
      buildFakeTag({ name: '2 000 000 participants' }),
      buildFakeTag({ name: '10 stands' }),
      buildFakeTag({ name: '2 toilets' }),
    ],
    kind: CARD_KIND.event,
    id: 1,
  };
};
