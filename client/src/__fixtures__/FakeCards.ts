import { CARD_KIND, CARD_MEDIA_TYPE } from '../constants';
import type { CompanyCard, MemberCard, EventCard, MediaCard } from '../domain';
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
    kind: CARD_KIND.COMPANY,
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
    kind: CARD_KIND.MEDIA,
    id: 1,
  };
};

export const buildFakeMediaCard = ({
  id,
  video,
  description,
  ctaUrl,
  ctaLabel,
  name,
}: Partial<MediaCard>): MediaCard => {
  return {
    kind: CARD_KIND.MEDIA,
    id: id || 666,
    video:
      video ||
      'https://test-videos.co.uk/vids/bigbuckbunny/mp4/h264/720/Big_Buck_Bunny_720_10s_2MB.mp4',
    ctaLabel: ctaLabel || 'My Nice event',
    ctaUrl: ctaUrl || '#',
    name: name || 'My name',
    description: description || 'My nice description',
    mediaType: CARD_MEDIA_TYPE.PRESS,
  };
};
