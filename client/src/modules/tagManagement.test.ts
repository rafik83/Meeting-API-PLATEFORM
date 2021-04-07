import type { Nomenclature } from '../domain';
import {
  buildFakeNomenclature,
  buildFakeNomenclatureTag,
  buildFakeTag,
} from '../__fixtures__/FakeTags';
import {
  filterTagsWithNoPriorities,
  updatePriorities,
  getTagsWithPriorityCount,
  getTagsMaxPriority,
  setTagPriorityToNullIfNotDefined,
  getTagsFromNomenclatureTags,
  getTagsFromNomenclature,
} from './tagManagement';

describe('priorities', () => {
  describe('getTagsMaxPriority', () => {
    it('should return the max priority from a nomenclature tag array', () => {
      const tag1 = buildFakeTag({ id: 2, priority: 666 });
      const tag2 = buildFakeTag({ id: 2, priority: 2 });

      expect(getTagsMaxPriority([tag1, tag2])).toBe(666);
    });

    it('should return the max priority from a nomenclature tag array', () => {
      const tag1 = buildFakeTag({ id: 2, priority: 666 });
      const tag2 = buildFakeTag({ id: 2, priority: null });

      expect(getTagsMaxPriority([tag1, tag2])).toBe(666);
    });

    it('should return the max priority from a nomenclature tag array', () => {
      const tag1 = buildFakeTag({ id: 2, priority: null });
      const tag2 = buildFakeTag({ id: 2, priority: null });

      expect(getTagsMaxPriority([tag1, tag2])).toBe(0);
    });

    it('should return the max priority from a nomenclature tag array', () => {
      const tag1 = buildFakeTag({ id: 2, priority: undefined });

      expect(getTagsMaxPriority([tag1])).toBe(NaN);
    });
  });
  describe('updatePriorities', () => {
    it('should update the selected tag priority with the highest priority if has no prior priority-', () => {
      const tag1 = buildFakeTag({ id: 1, priority: null });
      const tag2 = buildFakeTag({ id: 2, priority: null });
      const tag3 = buildFakeTag({ id: 3, priority: null });

      const expectedResult = [tag1, tag2, tag3];

      const selectedTag = buildFakeTag({ id: 666 });

      expect(updatePriorities(selectedTag, [tag1, tag2, tag3])).toStrictEqual(
        expectedResult
      );
    });

    it('should update the selected tag priority with the highest priority if has no prior priority set -- other tag with null priority case', () => {
      const myTagId = 333;

      const tag1 = buildFakeTag({ id: myTagId, priority: null });
      const tag2 = buildFakeTag({ id: 2, priority: null });

      const tags = [tag1, tag2];

      const selectedTag = buildFakeTag({ id: myTagId });

      const result = updatePriorities(selectedTag, tags);

      expect(result[0].priority).toBe(1);
      expect(result[1].priority).toBe(null);
    });

    it('should set the selected tag priority to null and decrease other tag priority ', () => {
      const myTagId = 333;
      const myTagPriority = 1;

      const selectedTag = buildFakeTag({
        id: myTagId,
        priority: myTagPriority,
      });

      const tag2 = buildFakeTag({ id: 2, priority: 2 });

      const tags = [selectedTag, tag2];

      const result = updatePriorities(selectedTag, tags);

      expect(result[0].priority).toBe(null);
      expect(result[1].priority).toBe(1);
    });

    it('should set the selected tag priority to null and only decrease other tag priority with higher priority values', () => {
      const myTagId = 333;
      const myTagPriority = 2;

      const selectedTag = buildFakeTag({
        id: myTagId,
        priority: myTagPriority,
      });
      const tag2 = buildFakeTag({ id: 2, priority: 1 });
      const tag3 = buildFakeTag({ id: 3, priority: 3 });

      const tags = [selectedTag, tag2, tag3];

      const result = updatePriorities(selectedTag, tags);

      expect(result[0].priority).toBe(null);
      expect(result[1].priority).toBe(1);
      expect(result[2].priority).toBe(2);
    });
  });

  describe('filterTagsWithNoPriorities', () => {
    it('should return only the tags with a priority', () => {
      const tagWitoutPriority = buildFakeTag({ priority: null });
      const tagWithPriority = buildFakeTag({ priority: 33 });

      expect(
        filterTagsWithNoPriorities([tagWitoutPriority, tagWithPriority])
      ).toStrictEqual([tagWithPriority]);
    });
  });

  describe('getTagsWithPriorityCount', () => {
    it('should return the tags with priority count', () => {
      const tagWitoutPriority = buildFakeTag({ priority: null });
      const tagWithPriority = buildFakeTag({ priority: 66 });

      expect(
        getTagsWithPriorityCount([tagWitoutPriority, tagWithPriority])
      ).toBe(1);
    });
  });

  describe('setTagPriorityToNullIfNotDefined', () => {
    it('should set the tag priority to null if undefined', () => {
      const tagWitoutPriority = buildFakeTag({ priority: undefined });
      const tagWithPriority = buildFakeTag({ priority: 66 });

      const result = setTagPriorityToNullIfNotDefined([
        tagWitoutPriority,
        tagWithPriority,
      ]);

      expect(result[0].priority).toBeNull();
      expect(result[1].priority).toBe(66);
    });
  });

  describe('getTagsFromNomenclatureTags', () => {
    it('should get the tags from nomenclature tags', () => {
      const tag1 = buildFakeTag({
        name: 'toto',
        priority: 33,
      });

      const tag2 = buildFakeTag({
        name: 'tuto',
        priority: 33,
      });

      const nomenclatureTag1 = buildFakeNomenclatureTag(tag1);
      const nomenclatureTag2 = buildFakeNomenclatureTag(tag2);

      expect(
        getTagsFromNomenclatureTags([nomenclatureTag1, nomenclatureTag2])
      ).toStrictEqual([tag1, tag2]);
    });
  });

  it('should return all tags from nomenclature ', () => {
    const tag1 = buildFakeTag({
      name: 'job1',
    });

    const tag2 = buildFakeTag({
      name: 'job2',
    });

    const jobPositionNomenclatureTag1 = buildFakeNomenclatureTag(tag1);

    const jobPositionNomenclatureTag2 = buildFakeNomenclatureTag(tag2);

    const nomenclature: Nomenclature = buildFakeNomenclature({
      tags: [jobPositionNomenclatureTag1, jobPositionNomenclatureTag2],
    });

    const result = getTagsFromNomenclature(nomenclature);
    expect(result).toStrictEqual([tag1, tag2]);
  });
});
