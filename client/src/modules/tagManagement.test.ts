import type { Nomenclature, TagTreeItem } from '../domain';
import {
  createGroupOfTreeItemsByParent,
  GroupedTreeItem,
  groupTreeItemByParent,
  updatePrioritiesWithinGroupedTreeItems,
} from './tagManagement';
import { buildFakeNomenclature, buildFakeTag } from '../__fixtures__/FakeTags';
import { buildFakeTreeItem } from '../__fixtures__/TreeItem';

import {
  buildTagTree,
  filterTagsWithNoPriorities,
  updatePriorities,
  getTagsFromNomenclature,
  getTagsMaxPriority,
  filterTagTree,
  getFirstLevelTreeItems,
  getTagsWithPriorityCount,
  setTagPriorityToNullIfNotDefined,
} from './tagManagement';

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

      const totoTreeItem: TagTreeItem = {
        children: [],
        tag: tagToto,
        parent: tagBuy,
      };

      const tataTreeItem: TagTreeItem = {
        children: [],
        tag: tagTata,
        parent: tagBuy,
      };

      const buyTreeItem: TagTreeItem = {
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

      const expectedResult: Array<TagTreeItem> = [
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

      const expectedTagA121TreeItem: TagTreeItem = {
        children: [],
        tag: tagA121,
        parent: tagA12,
      };

      const expectedTagA11TreeItem: TagTreeItem = {
        children: [],
        tag: tagA11,
        parent: tagA1,
      };

      const expectedTgA12TreeItem: TagTreeItem = {
        children: [expectedTagA121TreeItem],
        tag: tagA12,
        parent: tagA1,
      };

      const expectedTagA1TreeItem: TagTreeItem = {
        children: [expectedTagA11TreeItem, expectedTgA12TreeItem],
        tag: tagA1,
        parent: tagA,
      };

      const expectedTagA2TreeItem: TagTreeItem = {
        children: [],
        tag: tagA2,
        parent: tagA,
      };

      const expectedTagB1TreeItem: TagTreeItem = {
        children: [],
        tag: tagB1,
        parent: tagB,
      };

      const expectedTagATreeItem: TagTreeItem = {
        children: [expectedTagA1TreeItem, expectedTagA2TreeItem],
        tag: tagA,
        parent: null,
      };
      const expectedTagBTreeItem: TagTreeItem = {
        children: [expectedTagB1TreeItem],
        tag: tagB,
        parent: null,
      };
      const expectedTagCTreeItem: TagTreeItem = {
        children: [],
        tag: tagC,
        parent: null,
      };

      const expectedResult: Array<TagTreeItem> = [
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

  describe('filterTagTree', () => {
    it('should return a filtered TagTree', () => {
      const SpaceRDTag = buildFakeTag({
        name: 'Space R&D',
        id: 18,
      });

      const GroundTag = buildFakeTag({
        name: 'Ground',
        id: 10,
      });

      const SatelliteTag = buildFakeTag({
        name: 'Satellite',
        id: 8,
      });

      /* The tag tree looks like this :
       *
       *            Ground
       *              │
       *       ───────┴─────────────
       * Satellite            Space R&D
       */

      const spaceRDTreeItem = buildFakeTreeItem({
        tag: SpaceRDTag,
      });

      const SatelliteTreeItem = buildFakeTreeItem({
        tag: SatelliteTag,
      });

      const GroundTreeItem = buildFakeTreeItem({
        tag: GroundTag,
        parent: null,
        children: [spaceRDTreeItem, SatelliteTreeItem],
      });

      /*
                                      The user has selected those tags
                                    */

      const selectedTags = [SpaceRDTag];
      const expectedResult = [spaceRDTreeItem];

      const result = filterTagTree(GroundTreeItem, selectedTags);
      expect(result).toStrictEqual(expectedResult);
    });

    it('should return a filtered TagTree -- user has selected multiple tags from the tree', () => {
      const GroundTag = buildFakeTag({
        name: 'Ground',
        id: 10,
      });

      const SatelliteTag = buildFakeTag({
        name: 'Satellite',
        id: 8,
        parent: GroundTag,
      });

      const SpacecraftPowerTag = buildFakeTag({
        name: 'SpacecraftPower',
        id: 19,
        parent: GroundTag,
      });

      const SpaceRDTag = buildFakeTag({
        name: 'Space R&D',
        id: 18,
        parent: GroundTag,
      });

      /* The tag tree looks like this
       *         Ground
       *         │  │ │
       *         │  │ └──────────────┐
       *         │  │                │
       *         ▼  ▼                ▼
       * Satellite  Space R&D  Spacecraft Power
       */

      const SpaceRDTreeItem = buildFakeTreeItem({
        tag: SpaceRDTag,
        parent: GroundTag,
        children: [],
      });

      const SatelliteTreeItem = buildFakeTreeItem({
        tag: SatelliteTag,
        parent: GroundTag,
        children: [],
      });

      const SpacecraftPowerTreeItem = buildFakeTreeItem({
        tag: SpacecraftPowerTag,
        parent: GroundTag,
        children: [],
      });

      const GroundTreeItem = buildFakeTreeItem({
        tag: GroundTag,
        parent: null,
        children: [SpaceRDTreeItem, SatelliteTreeItem, SpacecraftPowerTreeItem],
      });

      /*
                                                                                            The user has selected those tags
                                                                                          */
      const selectedTags = [SatelliteTag, SpacecraftPowerTag];

      const expectedResult = [SatelliteTreeItem, SpacecraftPowerTreeItem];

      expect(filterTagTree(GroundTreeItem, selectedTags)).toStrictEqual(
        expectedResult
      );
    });

    it('should return a filtered TagTree -- with only one grand child', () => {
      /* The user has selected Space R&D Tag from the "Buy" nomenclature
       *  - Electronics
       */

      const GroundTag = buildFakeTag({
        name: 'Ground',
        id: 10,
      });

      const SatelliteTag = buildFakeTag({
        name: 'Satellite',
        id: 8,
        parent: GroundTag,
      });

      const ElectronicsTag = buildFakeTag({
        name: 'Electronics',
        id: 222,
        parent: SatelliteTag,
      });

      /* The tree looks like this :
       *
       *            Ground
       *            │
       *            │
       *            │
       *            ▼
       *          Satellite
       *              │
       *              |
       *              ▼
       *         Electronics
       */

      const ElectronicTreeItem = buildFakeTreeItem({
        tag: ElectronicsTag,
        parent: SatelliteTag,
      });

      const SatelliteTreeItem = buildFakeTreeItem({
        tag: SatelliteTag,
        parent: GroundTag,
        children: [ElectronicTreeItem],
      });

      const GroundTreeItem = buildFakeTreeItem({
        tag: GroundTag,
        parent: null,
        children: [SatelliteTreeItem],
      });

      // The user has selected those tags

      const selectedTags = [ElectronicsTag];

      const expectedTree = [ElectronicTreeItem];
      const result = filterTagTree(GroundTreeItem, selectedTags);

      expect(result).toStrictEqual(expectedTree);
    });

    it('should return a filtered TagTree -- grand children case', () => {
      const GroundTag = buildFakeTag({
        name: 'Ground',
        id: 10,
      });
      const SatelliteTag = buildFakeTag({
        name: 'Satellite',
        id: 8,
        parent: GroundTag,
      });

      const SpacecraftPowerTag = buildFakeTag({
        name: 'SpacecraftPower',
        id: 19,
        parent: GroundTag,
      });

      const OpticsTag = buildFakeTag({
        name: 'Optics',
        id: 444,
        parent: SatelliteTag,
      });

      const ElectronicsTag = buildFakeTag({
        name: 'Electronics',
        id: 222,
        parent: SatelliteTag,
      });

      const TurbineTag = buildFakeTag({
        name: 'Turbine',
        id: 999,
        parent: SpacecraftPowerTag,
      });

      const PistonTag = buildFakeTag({
        name: 'Piston',
        id: 8855555,
        parent: SpacecraftPowerTag,
      });

      /* The tree looks like this tree :
       *
       *            Ground
       *            │    │
       *            │    └──────────────┐
       *            │                   │
       *            ▼                   ▼
       *    Satellite          Spacecraft Power
       *   ┌───┘ └───┐ *        ┌───┘ └───┐
       *   ▼         ▼          ▼         ▼
       * Optics    Electronics  Turbine   Piston
       */

      const PistonTreeItem = buildFakeTreeItem({
        tag: PistonTag,
        parent: SpacecraftPowerTag,
        children: [],
      });
      const TurbineTreeItem = buildFakeTreeItem({
        tag: TurbineTag,
        parent: SpacecraftPowerTag,
      });

      const spaceCraftTreeItem = buildFakeTreeItem({
        tag: SpacecraftPowerTag,
        parent: GroundTag,
        children: [PistonTreeItem, TurbineTreeItem],
      });

      const opticTreeItem = buildFakeTreeItem({
        tag: OpticsTag,
        parent: SatelliteTag,
      });

      const ElectronicTreeItem = buildFakeTreeItem({
        tag: ElectronicsTag,
        parent: SatelliteTag,
      });

      const SatelliteTreeItem = buildFakeTreeItem({
        tag: SatelliteTag,
        parent: GroundTag,
        children: [opticTreeItem, ElectronicTreeItem],
      });

      const GroundTreeItem = buildFakeTreeItem({
        tag: GroundTag,
        parent: null,
        children: [SatelliteTreeItem, spaceCraftTreeItem],
      });

      // The user has selected those tags

      const selectedTags = [TurbineTag, OpticsTag];

      const expectedTree = [opticTreeItem, TurbineTreeItem];

      const result = filterTagTree(GroundTreeItem, selectedTags);

      expect(result).toStrictEqual(expectedTree);
    });
  });

  describe('getFirstLevelTags', () => {
    it('should return only the first level tags', () => {
      const GroundTag = buildFakeTag({
        name: 'Ground',
        id: 10,
      });

      const SpacecraftPowerTag = buildFakeTag({
        name: 'SpacecraftPower',
        id: 19,
      });

      const TurbineTag = buildFakeTag({
        name: 'Turbine',
        id: 999,
      });

      const PistonTag = buildFakeTag({
        name: 'Piston',
        id: 8855555,
      });

      const PistonTreeItem = buildFakeTreeItem({
        tag: PistonTag,
        parent: SpacecraftPowerTag,
      });
      const TurbineTreeItem = buildFakeTreeItem({
        tag: TurbineTag,
        parent: SpacecraftPowerTag,
      });

      const spaceCraftTreeItem = buildFakeTreeItem({
        tag: SpacecraftPowerTag,
        parent: GroundTag,
        children: [PistonTreeItem, TurbineTreeItem],
      });

      const GroundTreeItem = buildFakeTreeItem({
        tag: GroundTag,
        parent: null,
        children: [spaceCraftTreeItem],
      });

      /* The tree looks like this tree :
       *
       *            Ground
       *            │    │
       *            │    └──────────────┐
       *            │                   │
       *            ▼                   ▼
       *    Satellite          Spacecraft Power
       *   ┌───┘ └───┐ *        ┌───┘ └───┐
       *   ▼         ▼          ▼         ▼
       * Optics    Electronics  Turbine   Piston
       */

      const tree = [
        GroundTreeItem,
        spaceCraftTreeItem,
        PistonTreeItem,
        TurbineTreeItem,
      ];

      const result = getFirstLevelTreeItems(tree);

      expect(result).toStrictEqual([GroundTreeItem]);
    });
  });
  describe('groupTreeItemByParent', () => {
    it('should an array of tag item grouped by parent', () => {
      const GroundTag = buildFakeTag({
        name: 'Ground',
        id: 10,
      });

      const SpacecraftPowerTag = buildFakeTag({
        name: 'SpacecraftPower',
        id: 19,
      });

      const TurbineTag = buildFakeTag({
        name: 'Turbine',
        id: 999,
      });

      const PistonTag = buildFakeTag({
        name: 'Piston',
        id: 8855555,
      });

      const PistonTreeItem = buildFakeTreeItem({
        tag: PistonTag,
        parent: SpacecraftPowerTag,
      });
      const TurbineTreeItem = buildFakeTreeItem({
        tag: TurbineTag,
        parent: SpacecraftPowerTag,
      });

      const spaceCraftTreeItem = buildFakeTreeItem({
        tag: SpacecraftPowerTag,
        parent: GroundTag,
        children: [PistonTreeItem, TurbineTreeItem],
      });

      const GroundTreeItem = buildFakeTreeItem({
        tag: GroundTag,
        parent: null,
        children: [spaceCraftTreeItem],
      });

      const tree = [
        GroundTreeItem,
        spaceCraftTreeItem,
        PistonTreeItem,
        TurbineTreeItem,
      ];

      const groupedTreeItem1: GroupedTreeItem = {
        parent: GroundTag,
        children: [SpacecraftPowerTag],
      };

      const groupedTreeItem2: GroupedTreeItem = {
        parent: SpacecraftPowerTag,
        children: [PistonTag, TurbineTag],
      };

      const expectedResult = [groupedTreeItem1, groupedTreeItem2];
      const result = groupTreeItemByParent(tree);

      expect(result).toStrictEqual(expectedResult);
    });
  });

  describe('createGroupOfTreeItemsByParent', () => {
    it('should return few groups of f', () => {
      const GroundTag = buildFakeTag({
        name: 'Ground',
        id: 10,
      });

      const ElectronicTag = buildFakeTag({
        name: 'Electronic',
        id: 10,
      });

      const SatelliteTag = buildFakeTag({
        name: 'Satellite',
        id: 10,
      });

      const OpticsTag = buildFakeTag({
        name: 'Optics',
        id: 444,
        parent: SatelliteTag,
      });

      const SpacecraftPowerTag = buildFakeTag({
        name: 'SpacecraftPower',
        id: 19,
      });

      const TurbineTag = buildFakeTag({
        name: 'Turbine',
        id: 999,
      });

      const PistonTag = buildFakeTag({
        name: 'Piston',
        id: 8855555,
      });

      const PistonTreeItem = buildFakeTreeItem({
        tag: PistonTag,
        parent: SpacecraftPowerTag,
      });
      const TurbineTreeItem = buildFakeTreeItem({
        tag: TurbineTag,
        parent: SpacecraftPowerTag,
      });

      const opticTreeItem = buildFakeTreeItem({
        tag: OpticsTag,
        parent: SatelliteTag,
      });

      const ElectronicTreeItem = buildFakeTreeItem({
        tag: ElectronicTag,
        parent: SatelliteTag,
      });

      const satelliteTreeItem = buildFakeTreeItem({
        tag: SatelliteTag,
        parent: GroundTag,
        children: [opticTreeItem, ElectronicTreeItem],
      });

      const spaceCraftTreeItem = buildFakeTreeItem({
        tag: SpacecraftPowerTag,
        parent: GroundTag,
        children: [PistonTreeItem, TurbineTreeItem],
      });

      /* The trees looks like this
       *
       *    Satellite          Spacecraft Power
       *   ┌───┘ └───┐ *        ┌───┘ └───┐
       *   ▼         ▼          ▼         ▼
       * Optics    Electronics  Turbine   Piston
       */

      // The user has selected those tags

      const selectedTags = [PistonTag, TurbineTag, ElectronicTag, OpticsTag];

      const result = createGroupOfTreeItemsByParent(
        [satelliteTreeItem, spaceCraftTreeItem],
        selectedTags
      );

      const groupedTreeItem1: GroupedTreeItem = {
        parent: SatelliteTag,
        children: [OpticsTag, ElectronicTag],
      };

      const groupedTreeItem2: GroupedTreeItem = {
        parent: SpacecraftPowerTag,
        children: [PistonTag, TurbineTag],
      };

      const expectedResult = [groupedTreeItem1, groupedTreeItem2];

      expect(result).toStrictEqual(expectedResult);
    });
  });

  describe('updatePrioritiesWithinGroupedTreeItems', () => {
    it('should update tag priorities within grouped tree items', () => {
      const SatelliteTag = buildFakeTag({
        name: 'Satellite',
        id: 10,
      });

      const ElectronicTag = buildFakeTag({
        name: 'Electronic',
        id: 10,
      });

      const OpticsTag = buildFakeTag({
        name: 'Optics',
        id: 444,
      });

      const SpacecraftPowerTag = buildFakeTag({
        name: 'SpacecraftPower',
        id: 19,
      });

      const TurbineTag = buildFakeTag({
        name: 'Turbine',
        id: 999,
      });

      const PistonTag = buildFakeTag({
        name: 'Piston',
        id: 8855555,
      });

      const groupedTreeItem1: GroupedTreeItem = {
        parent: SatelliteTag,
        children: [OpticsTag, ElectronicTag],
      };

      const groupedTreeItem2: GroupedTreeItem = {
        parent: SpacecraftPowerTag,
        children: [PistonTag, TurbineTag],
      };

      const PistonTagPriority = buildFakeTag({
        name: 'Piston',
        id: 8855555,
        priority: 3,
      });

      const OpticsTagPriority = buildFakeTag({
        name: 'Optics',
        id: 444,
        priority: 2,
      });

      const groupedTreeItem1Priority: GroupedTreeItem = {
        parent: SatelliteTag,
        children: [OpticsTagPriority, ElectronicTag],
      };

      const groupedTreeItem2Priority: GroupedTreeItem = {
        parent: SpacecraftPowerTag,
        children: [PistonTagPriority, TurbineTag],
      };

      const result = updatePrioritiesWithinGroupedTreeItems(
        [PistonTagPriority, TurbineTag, OpticsTagPriority, ElectronicTag],
        [groupedTreeItem1, groupedTreeItem2]
      );

      const expectedResult = [
        groupedTreeItem1Priority,
        groupedTreeItem2Priority,
      ];
      expect(result).toStrictEqual(expectedResult);
    });

    it('should update tag priorities within grouped tree items', () => {
      const SatelliteTag = buildFakeTag({
        name: 'Satellite',
        id: 10,
      });

      const ElectronicTag = buildFakeTag({
        name: 'Electronic',
        id: 10,
      });

      const OpticsTag = buildFakeTag({
        name: 'Optics',
        id: 444,
      });

      const TurbineTag = buildFakeTag({
        name: 'Turbine',
        id: 999,
      });

      const PistonTag = buildFakeTag({
        name: 'Piston',
        id: 8855555,
      });

      const groupedTreeItem1: GroupedTreeItem = {
        parent: SatelliteTag,
        children: [PistonTag, TurbineTag, OpticsTag, ElectronicTag],
      };

      const PistonTagPriority = buildFakeTag({
        name: 'Piston',
        id: 8855555,
        priority: 3,
      });

      const OpticsTagPriority = buildFakeTag({
        name: 'Optics',
        id: 444,
        priority: 2,
      });

      const groupedTreeItem1Priority: GroupedTreeItem = {
        parent: SatelliteTag,
        children: [
          PistonTagPriority,
          TurbineTag,
          OpticsTagPriority,
          ElectronicTag,
        ],
      };

      const result = updatePrioritiesWithinGroupedTreeItems(
        [PistonTagPriority, TurbineTag, OpticsTagPriority, ElectronicTag],
        [groupedTreeItem1]
      );
      const expectedResult = [groupedTreeItem1Priority];
      expect(result).toStrictEqual(expectedResult);
    });
  });
});
