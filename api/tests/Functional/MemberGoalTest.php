<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Domain\Entity\Nomenclature\NomenclatureTag;
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

        /** @var Goal $goal */
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

        /** @var Goal $goal */
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

        /** @var Goal $goal */
        $goal = $member->getCommunity()->getGoals()->first();
        $tag = $goal->getNomenclature()->getTags()->first()->getTag();

        $this->request('POST', sprintf('/api/members/%d/goals', $member->getId()), [
            'goal' => $goal->getId(),
            'tags' => [['id' => $tag->getId(), 'priority' => null]],
        ]);

        self::assertResponseStatusCodeSame(401);
    }

    public function testInvalidGoal(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var Goal $goal */
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

        self::assertCount(1, $response->toArray(false)['violations']);
    }

    public function testInvalidTag(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var Goal $goal */
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
                    'propertyPath' => 'tags',
                    'message' => 'Some tags are not linked to this goal',
                    'code' => '84feafe3-ac47-4932-a5f1-229d9ca623b6',
                ],
            ],
        ]);

        self::assertCount(2, $response->toArray(false)['violations']);
    }

    public function testInvalidGoalMin(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var Goal $goal */
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

    public function testInvalidGoalMax(): void
    {
        $this->login('member@example.com');
        $member = $this->getMember('member@example.com', 'Space industry');

        /** @var Goal $goal */
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

    public function testInvalidParentNotSet(): void
    {
        $this->login('joined@example.com');
        $member = $this->getMember('joined@example.com', 'Space industry');

        $goal = $member->getCommunity()->getGoals()->filter(fn (Goal $goal) => $goal->getTag() !== null && $goal->getTag()->getLabel() === 'sell')->first();

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
}
