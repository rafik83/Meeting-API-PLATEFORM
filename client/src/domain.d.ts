export type Credentials = {
  username: string;
  password: string;
};

export type SupportedLanguages = 'fr' | 'en';

export type User = {
  firstName: string;
  lastName: string;
  password?: string;
  id?: number;
  email: string;
  acceptedTermsAndConditions?: number | Date;
  company?: Company;
  members: Array<Member>;
};

export type Community = {
  name: string;
};

export type Tag = {
  parent?: Tag;
  priority?: number;
  name: string;
  id: number;
};

export type Nomenclature = {
  id: number;
  reference: string;
  tags: Array<Tag>;
};

export type Member = {
  id: number;
  joinedAt: Date;
  community: number;
};

export type Country = {
  code: string;
  name: string;
};

export type Language = {
  code: string;
  name: string;
};

export type Company = {
  id?: number;
  name: string;
  logo?: string;
  country?: string;
  countryCode: string;
  activity: string;
  website: string;
  hubspotId?: string;
};

export type TimeZone = {
  code: string;
  name: string;
};

export type MemberGoal = {
  goal: CommunityGoal;
  tags: Array<{
    priority: number;
    tag: Tag;
  }>;
};

export type CommunityGoal = {
  id: number;
  community: number;
  nomenclature: Nomenclature;
  min: number;
  max: number;
  tag: Tag;
  parent?: number;
};

export type TagTreeItem = {
  children: TagTreeItem[];
  tag: Tag;
  parent: Tag | null;
};

export type Video = {
  sources: Array<VideoSource>;
};

export type VideoSource = {
  source: string;
  type: string;
};

export type CompanyCard = {
  kind: string;
  picture: string;
  name: string;
  activity: string;
  id: number;
};

export type MemberCard = {
  kind: string;
  firstName: string;
  lastName: string;
  id: number;
  picture: string;
  companyName: string;
  languageCodes: Array<string>;
  mainGoal: Tag;
  secondaryGoal: Tag;
  jobPosition: string;
  goals: Array<Tag>;
};

export type EventCard = {
  picture: string;
  name: string;
  startDate: string;
  endDate: string;
  eventType: string;
  registerUrl: string;
  findOutMoreUrl: string;
  tags: Array<Tag>;
  kind: string;
  id: number;
};

export type Card = CompanyCard | MemberCard | EventCard;

export type CommunityList = {
  id: string;
  position: number;
  title: string;
};

export type DateObject = {
  day: string;
  month: string;
  year: string;
};
