export type Credentials = {
  username: string;
  password: string;
};

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
