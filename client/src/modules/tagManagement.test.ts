import { buildFakeNomenclature, buildFakeTag } from '../__fixtures__/FakeTags';

import type { TreeItem } from './tagManagement';
import {
  buildTagTree,
  filterTagsWithNoPriorities,
  updatePriorities,
  getTagsFromNomenclature,
  getTagsMaxPriority,
  getTagsWithPriorityCount,
  setTagPriorityToNullIfNotDefined,
} from './tagManagement';

import type { Nomenclature } from '../domain';

describe('tagManagaement', () => {
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

  it('should return all tags from nomenclature ', () => {
    const tag1 = buildFakeTag({
      name: 'job1',
    });

    const tag2 = buildFakeTag({
      name: 'job2',
    });

    const nomenclature: Nomenclature = buildFakeNomenclature({
      tags: [tag1, tag2],
    });

    const result = getTagsFromNomenclature(nomenclature);
    expect(result).toStrictEqual([tag1, tag2]);
  });

  describe('buildTagTree', () => {
    it('should return a tree', () => {
      const tagBuy = buildFakeTag({
        name: 'Buy',
        id: 333,
      });

      const tagToto = buildFakeTag({
        name: 'Toto',
        id: 222,
        parent: tagBuy,
      });

      const tagTata = buildFakeTag({
        name: 'Tata',
        id: 566,
        parent: tagBuy,
      });

      const result = buildTagTree([tagBuy, tagToto, tagTata]);

      const totoTreeItem: TreeItem = {
        children: [],
        tag: tagToto,
        parent: tagBuy,
      };

      const tataTreeItem: TreeItem = {
        children: [],
        tag: tagTata,
        parent: tagBuy,
      };

      const buyTreeItem: TreeItem = {
        children: [totoTreeItem, tataTreeItem],
        tag: tagBuy,
        parent: null,
      };

      /* The expected tree should look like this
       *         Buy
       *          │
       *          │
       *    ┌─────┴──────┐
       *    ▼            ▼
       * Toto           Tata
       */

      const expectedResult: Array<TreeItem> = [
        buyTreeItem,
        totoTreeItem,
        tataTreeItem,
      ];

      expect(result).toStrictEqual(expectedResult);
    });

    it('should return a very complex tree', () => {
      const tagA = buildFakeTag({
        name: 'a',
        id: 1,
      });

      const tagB = buildFakeTag({
        name: 'b',
        id: 2,
      });

      const tagC = buildFakeTag({
        name: 'c',
        id: 3,
      });

      const tagA1 = buildFakeTag({
        name: 'a1',
        id: 4,
        parent: tagA,
      });

      const tagA2 = buildFakeTag({
        name: 'a2',
        id: 5,
        parent: tagA,
      });

      const tagA11 = buildFakeTag({
        name: 'a11',
        id: 6,
        parent: tagA1,
      });

      const tagA12 = buildFakeTag({
        name: 'a12',
        id: 7,
        parent: tagA1,
      });

      const tagA121 = buildFakeTag({
        name: 'a121',
        id: 8,
        parent: tagA12,
      });

      const tagB1 = buildFakeTag({
        name: 'b1',
        id: 9,
        parent: tagB,
      });

      const result = buildTagTree([
        tagA,
        tagB,
        tagC,
        tagA1,
        tagA2,
        tagA11,
        tagA12,
        tagA121,
        tagB1,
      ]);

      const expectedTagA121TreeItem: TreeItem = {
        children: [],
        tag: tagA121,
        parent: tagA12,
      };

      const expectedTagA11TreeItem: TreeItem = {
        children: [],
        tag: tagA11,
        parent: tagA1,
      };

      const expectedTgA12TreeItem: TreeItem = {
        children: [expectedTagA121TreeItem],
        tag: tagA12,
        parent: tagA1,
      };

      const expectedTagA1TreeItem: TreeItem = {
        children: [expectedTagA11TreeItem, expectedTgA12TreeItem],
        tag: tagA1,
        parent: tagA,
      };

      const expectedTagA2TreeItem: TreeItem = {
        children: [],
        tag: tagA2,
        parent: tagA,
      };

      const expectedTagB1TreeItem: TreeItem = {
        children: [],
        tag: tagB1,
        parent: tagB,
      };

      const expectedTagATreeItem: TreeItem = {
        children: [expectedTagA1TreeItem, expectedTagA2TreeItem],
        tag: tagA,
        parent: null,
      };
      const expectedTagBTreeItem: TreeItem = {
        children: [expectedTagB1TreeItem],
        tag: tagB,
        parent: null,
      };
      const expectedTagCTreeItem: TreeItem = {
        children: [],
        tag: tagC,
        parent: null,
      };

      const expectedResult: Array<TreeItem> = [
        expectedTagATreeItem,
        expectedTagBTreeItem,
        expectedTagCTreeItem,
        expectedTagA1TreeItem,
        expectedTagA2TreeItem,
        expectedTagA11TreeItem,
        expectedTgA12TreeItem,
        expectedTagA121TreeItem,
        expectedTagB1TreeItem,
      ];

      expect(result).toStrictEqual(expectedResult);
    });
  });
});
