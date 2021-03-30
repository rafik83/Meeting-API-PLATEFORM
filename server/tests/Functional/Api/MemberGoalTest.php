<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Api;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal as CommunityGoal;
use Proximum\Vimeet365\Core\Domain\Entity\Member\Goal as MemberGoal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature\NomenclatureTag;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;

class MemberGoalTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testList(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        $this->request('GET', sprintf('/api/members/%d/goals', $member->getId()));

        self::assertResponseIsSuccessful();
    }

    public function testListNotMine(): void
    {
        $this->login('joined@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        $this->request('GET', sprintf('/api/members/%d/goals', $member->getId()));

        self::assertResponseStatusCodeSame(403);
    }

    public function testListNotAuthenticated(): void
    {
        $member = $this->getMember('member@example.com', 'Space industry');

        $this->request('GET', sprintf('/api/members/%d/goals', $member->getId()));

        self::assertResponseStatusCodeSame(401);
    }

    public function testSet(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var CommunityGoal $goal */
        $goal = $member->getCommunity()->getGoals()->first();
        $tag = $goal->getNomenclature()->getTags()->first()->getTag();

        $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => $goal->getId(),
            'tags' => [['id' => $tag->getId(), 'priority' => null]],
        ]);

        self::assertResponseIsSuccessful();
    }

    public function testSetNotMine(): void
    {
        $this->login('joined@example.com');

        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var CommunityGoal $goal */
        $goal = $member->getCommunity()->getGoals()->first();
        $tag = $goal->getNomenclature()->getTags()->first()->getTag();

        $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => $goal->getId(),
            'tags' => [['id' => $tag->getId(), 'priority' => null]],
        ]);

        self::assertResponseStatusCodeSame(403);
    }

    public function testSetNotAuthenticated(): void
    {
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var CommunityGoal $goal */
        $goal = $member->getCommunity()->getGoals()->first();
        $tag = $goal->getNomenclature()->getTags()->first()->getTag();

        $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => $goal->getId(),
            'tags' => [['id' => $tag->getId(), 'priority' => null]],
        ]);

        self::assertResponseStatusCodeSame(401);
    }

    public function testSetInvalidGoal(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var CommunityGoal $goal */
        $goal = $member->getCommunity()->getGoals()->first();
        $tag = $goal->getNomenclature()->getTags()->first()->getTag();

        $response = $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => 0,
            'tags' => [['id' => $tag->getId(), 'priority' => null]],
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'goal',
                    'message' => "The goal doesn't belong to the current community",
                    'code' => '2412ae29-2218-493c-9942-659ef0482a91',
                ],
            ],
        ]);

        self::assertCount(2, $response->toArray(false)['violations']);
    }

    public function testSetInvalidTag(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var CommunityGoal $goal */
        $goal = $member->getCommunity()->getGoals()->first();

        $response = $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => $goal->getId(),
            'tags' => [['id' => 0, 'priority' => null]],
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'tags[0].id',
                    'message' => 'The tag does not belong to the chosen goal',
                    'code' => '4f0b294d-9ee4-4777-90e4-42b4192b2713',
                ],
            ],
        ]);

        self::assertCount(2, $response->toArray(false)['violations']);
    }

    public function testSetInvalidGoalMin(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var CommunityGoal $goal */
        $goal = $member->getCommunity()->getGoals()->first();

        $response = $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => $goal->getId(),
            'tags' => [],
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'tags',
                    'message' => 'This collection should contain 1 element or more.',
                    'code' => 'bef8e338-6ae5-4caf-b8e2-50e7b0579e69',
                ],
            ],
        ]);

        self::assertCount(1, $response->toArray(false)['violations']);
    }

    public function testSetInvalidGoalMax(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var CommunityGoal $goal */
        $goal = $member->getCommunity()->getGoals()->first();
        $tags = $goal->getNomenclature()->getTags()->map(
            fn (NomenclatureTag $nomenclatureTag): array => [
                'id' => $nomenclatureTag->getTag()->getId(),
                'priority' => null,
            ]
        );
        $response = $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => $goal->getId(),
            'tags' => $tags,
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'tags',
                    'message' => 'This collection should contain 1 element or more.',
                ],
            ],
        ]);

        self::assertCount(1, $response->toArray(false)['violations']);
    }

    public function testSetInvalidParentNotSet(): void
    {
        $this->login('joined@example.com');
        $member = $this->getMember('joined@example.com', 'Space industry');

        $goal = $member->getCommunity()->getGoals()->filter(fn (CommunityGoal $goal) => $goal->getTag() !== null && $goal->getTag()->getLabel() === 'sell')->first();

        $response = $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => $goal->getId(),
            'tags' => [['id' => $this->getTagId('Optics'), 'priority' => null]],
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'goal',
                    'message' => 'Can\'t edit this goal as the parent goal is not configured',
                    'code' => '3ee827e4-d3e8-4fa2-ad67-c2480e04d5d8',
                ],
            ],
        ]);

        self::assertCount(1, $response->toArray(false)['violations']);
    }

    public function testRank(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');
        $community = $member->getCommunity();

        /** @var CommunityGoal $communityGoal */
        $communityGoal = $community->getGoals()->filter(
            fn (CommunityGoal $communityGoal): bool => $communityGoal->getTag() !== null && $communityGoal->getTag()->getLabel() === 'sell'
        )->first();

        $memberGoals = $member->getGoals()->filter(fn (MemberGoal $memberGoal): bool => $memberGoal->getCommunityGoal()->getId() === $communityGoal->getId());

        $ids = $memberGoals->map(fn (MemberGoal $memberGoal): int => $memberGoal->getTag()->getId())->slice(0, 3);

        $tags = [];
        foreach ($ids as $i => $id) {
            $tags[] = ['id' => $id, 'priority' => $i];
        }

        $this->request('POST', sprintf('/api/members/%d/goals-ranking', $member->getId()), [
            'goal' => $communityGoal->getId(),
            'tags' => $tags,
        ]);

        self::assertResponseIsSuccessful();

        self::assertJsonContains([
            'hydra:member' => [
                2 => [
                    '@type' => 'MemberGoalView',
                    'tags' => [
                            [
                                'tag' => ['name' => 'Satellites'],
                                'priority' => 2,
                            ],
                            [
                                'tag' => ['name' => 'Optics'],
                                'priority' => 3,
                            ],
                            [
                                'tag' => ['name' => 'Mission Operation and Ground Data systems'],
                                'priority' => 4,
                            ],
                            [
                                'tag' => ['name' => 'Spacecraft Electrical Power'],
                                'priority' => null,
                            ],
                        ],
                ],
            ],
        ]);
    }

    public function testRankNotMine(): void
    {
        $this->login('joined@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');
        $community = $member->getCommunity();

        /** @var CommunityGoal $communityGoal */
        $communityGoal = $community->getGoals()->filter(
            fn (CommunityGoal $communityGoal): bool => $communityGoal->getTag() !== null && $communityGoal->getTag()->getLabel() === 'sell'
        )->first();

        $memberGoals = $member->getGoals()->filter(fn (MemberGoal $memberGoal): bool => $memberGoal->getCommunityGoal()->getId() === $communityGoal->getId());

        $ids = $memberGoals->map(fn (MemberGoal $memberGoal): int => $memberGoal->getTag()->getId())->slice(0, 3);

        $tags = [];
        foreach ($ids as $i => $id) {
            $tags[] = ['id' => $id, 'priority' => $i];
        }

        $this->request('POST', sprintf('/api/members/%d/goals-ranking', $member->getId()), [
            'goal' => $communityGoal->getId(),
            'tags' => $tags,
        ]);

        self::assertResponseStatusCodeSame(403);
    }

    public function testRankNotAuthenticated(): void
    {
        $member = $this->getMember('member@example.com', 'Space industry');
        $community = $member->getCommunity();

        /** @var CommunityGoal $communityGoal */
        $communityGoal = $community->getGoals()->filter(
            fn (CommunityGoal $communityGoal): bool => $communityGoal->getTag() !== null && $communityGoal->getTag()->getLabel() === 'sell'
        )->first();

        $memberGoals = $member->getGoals()->filter(fn (MemberGoal $memberGoal): bool => $memberGoal->getCommunityGoal()->getId() === $communityGoal->getId());

        $ids = $memberGoals->map(fn (MemberGoal $memberGoal): int => $memberGoal->getTag()->getId())->slice(0, 3);

        $tags = [];
        foreach ($ids as $i => $id) {
            $tags[] = ['id' => $id, 'priority' => $i];
        }

        $this->request('POST', sprintf('/api/members/%d/goals-ranking', $member->getId()), [
            'goal' => $communityGoal->getId(),
            'tags' => $tags,
        ]);

        self::assertResponseStatusCodeSame(401);
    }

    public function testRankTooManyTags(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');
        $community = $member->getCommunity();

        /** @var CommunityGoal $communityGoal */
        $communityGoal = $community->getGoals()->filter(
            fn (CommunityGoal $communityGoal): bool => $communityGoal->getTag() !== null && $communityGoal->getTag()->getLabel() === 'sell'
        )->first();

        $memberGoals = $member->getGoals()->filter(fn (MemberGoal $memberGoal): bool => $memberGoal->getCommunityGoal()->getId() === $communityGoal->getId());

        $ids = $memberGoals->map(fn (MemberGoal $memberGoal): int => $memberGoal->getTag()->getId())->getValues();

        $tags = [];
        foreach ($ids as $i => $id) {
            $tags[] = ['id' => $id, 'priority' => $i];
        }

        $this->request('POST', sprintf('/api/members/%d/goals-ranking', $member->getId()), [
            'goal' => $communityGoal->getId(),
            'tags' => $tags,
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'tags',
                    'message' => 'This collection should contain 3 elements or less.',
                    'code' => '756b1212-697c-468d-a9ad-50dd783bb169',
                ],
            ],
        ]);
    }

    public function testRankTooInvalidGoal(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');
        $community = $member->getCommunity();

        /** @var CommunityGoal $communityGoal */
        $communityGoal = $community->getGoals()->filter(
            fn (CommunityGoal $communityGoal): bool => $communityGoal->getTag() !== null && $communityGoal->getTag()->getLabel() === 'sell'
        )->first();

        $memberGoals = $member->getGoals()->filter(fn (MemberGoal $memberGoal): bool => $memberGoal->getCommunityGoal()->getId() === $communityGoal->getId());

        $ids = $memberGoals->map(fn (MemberGoal $memberGoal): int => $memberGoal->getTag()->getId())->getValues();

        $tags = [];
        foreach ($ids as $i => $id) {
            $tags[] = ['id' => $id, 'priority' => $i];
        }

        $this->request('POST', sprintf('/api/members/%d/goals-ranking', $member->getId()), [
            'goal' => 0,
            'tags' => $tags,
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'goal',
                    'message' => "The goal doesn't belong to the current community",
                    'code' => '2412ae29-2218-493c-9942-659ef0482a91',
                ],
            ],
        ]);
    }

    public function testRankTooInvalidTag(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');
        $community = $member->getCommunity();

        /** @var CommunityGoal $communityGoal */
        $communityGoal = $community->getGoals()->filter(
            fn (CommunityGoal $communityGoal): bool => $communityGoal->getTag() !== null && $communityGoal->getTag()->getLabel() === 'sell'
        )->first();

        $this->request('POST', sprintf('/api/members/%d/goals-ranking', $member->getId()), [
            'goal' => $communityGoal->getId(),
            'tags' => [['id' => $this->getTagId('A Supplier'), 'priority' => 0]],
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'tags[0].id',
                    'message' => 'The tag does not belong to the chosen goal',
                    'code' => '4f0b294d-9ee4-4777-90e4-42b4192b2713',
                ],
            ],
        ]);
    }

    public function testRankNotSetTag(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');
        $community = $member->getCommunity();

        /** @var CommunityGoal $communityGoal */
        $communityGoal = $community->getGoals()->filter(
            fn (CommunityGoal $communityGoal): bool => $communityGoal->getTag() !== null && $communityGoal->getTag()->getLabel() === 'sell'
        )->first();

        $this->request('POST', sprintf('/api/members/%d/goals-ranking', $member->getId()), [
            'goal' => $communityGoal->getId(),
            'tags' => [['id' => $this->getTagId('Ground'), 'priority' => 0]],
        ]);

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => [
                [
                    'propertyPath' => 'tags[0].id',
                    'message' => 'The tag is not used in this goal',
                    'code' => 'ef0d490c-97fa-417c-93d6-5e8635dfa268',
                ],
            ],
        ]);
    }
}
