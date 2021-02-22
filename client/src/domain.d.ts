export type Crendentials = {
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
};

export type Community = {
  name: string;
};

export type Tag = {
  priority?: number;
  name: string;
  id: number;
};

export type NomenclatureTag = {
  tag: Tag;
  parent?: Tag;
};

export type Nomenclature = {
  id: number;
  name: string;
  tags: Array<NomenclatureTag>;
};
export type QualificationStep = {
  id: number;
  description: string;
  nomenclature: Nomenclature;
  position: number;
  title: string;
  min: number;
  max: number;
};

export type Member = {
  id: number;
  joinedAt: Date;
  currentQualificationStep: QualificationStep;
};

export type Country = {
  id: string;
  name: string;
}