<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional;

use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Domain\Entity\Tag;
use Proximum\Vimeet365\Infrastructure\Repository\AccountRepository;
use Proximum\Vimeet365\Infrastructure\Repository\CommunityRepository;
use Proximum\Vimeet365\Tests\Util\ApiTestCase;

class MemberTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testJoin(): void
    {
        $this->login('user@example.com');

        $communityId = $this->getCommunity('Space industry')->getId();

        $this->request('POST', '/api/members', ['community' => $communityId]);

        self::assertResponseStatusCodeSame(201);

        self::assertJsonContains([
            '@type' => 'Member',
            'currentQualificationStep' => [
                '@type' => 'CommunityStepView',
                'nomenclature' => [],
            ],
            'tagsByNomenclature' => [],
        ]);
    }

    public function testJoinAlreadyJoin(): void
    {
        $this->login('member@example.com');
        $communityId = $this->getCommunity('Space industry')->getId();

        $this->request('POST', '/api/members', ['community' => $communityId]);

        self::assertResponseStatusCodeSame(201);

        self::assertJsonContains([
            '@type' => 'Member',
        ]);
    }

    public function testSetCommunityTag(): void
    {
        $this->login('joined@example.com');

        $community = $this->getCommunity('Space industry');
        $member = $this->getMember('joined@example.com', $community);

        $currentStepId = $member->getCurrentQualificationStep()->getId();
        $firstTag = $member->getCurrentQualificationStep()->getNomenclature()->getTags()->first()->getTag()->getId();

        $this->request(
            'PATCH',
            '/api/members/' . $member->getId(),
            [
                'step' => $currentStepId,
                'tags' => [
                    ['id' => $firstTag, 'priority' => 0],
                ],
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(200);

        self::assertJsonContains([
            '@type' => 'Member',
            'currentQualificationStep' => [
                '@type' => 'CommunityStepView',
                'nomenclature' => [],
            ],
            'tagsByNomenclature' => [],
        ]);
    }

    public function testSetCommunityTagCompletedProfile(): void
    {
        $this->login('joined@example.com');

        $community = $this->getCommunity('Space industry');
        $member = $this->getMember('joined@example.com', $community);

        $currentStepId = $community->getSteps()->first()->getId();
        $firstTag = $community->getSteps()->first()->getNomenclature()->getTags()->first()->getTag()->getId();

        $this->request(
            'PATCH',
            '/api/members/' . $member->getId(),
            [
                'step' => $currentStepId,
                'tags' => [
                    ['id' => $firstTag, 'priority' => 0],
                ],
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(200);

        self::assertJsonContains([
            '@type' => 'Member',
            'tagsByNomenclature' => [],
        ]);
    }

    /**
     * @dataProvider provideTestSetCommunityTagInvalid
     */
    public function testSetCommunityTagInvalid(string $email, string $currentStep, array $tags, array $expectedViolations): void
    {
        $this->login($email);

        $community = $this->getCommunity('Space industry');
        $member = $this->getMember($email, $community);

        $step = $community->getSteps()->filter(fn (Community\Step $step): bool => $step->getTitle() === $currentStep)->first();

        if ($step === false) {
            $stepId = -1;
        } else {
            $stepId = $step->getId();
        }

        $tags = array_map(fn (array $nomenclatureTag) => [
            'priority' => $nomenclatureTag['priority'],
            'id' => $this->getTagId($nomenclatureTag['name']),
        ], $tags);

        $this->request(
            'PATCH',
            '/api/members/' . $member->getId(),
            [
                'step' => $stepId,
                'tags' => $tags,
            ], [
                'content-type' => 'application/merge-patch+json',
            ]
        );

        self::assertResponseStatusCodeSame(422);

        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'violations' => $expectedViolations,
        ]);
    }

    public function provideTestSetCommunityTagInvalid(): iterable
    {
        yield 'invalid step' => [
            'joined@example.com',
            'Undefined',
            [['name' => 'A Supplier', 'priority' => 0]],
            [
                [
                    'propertyPath' => 'step',
                    'message' => 'The step -1 does not belong to the member community',
                ],
            ],
        ];

        yield 'invalid priority' => [
            'joined@example.com',
            'I am',
            [['name' => 'A Supplier', 'priority' => -1]],
            [
                [
                    'propertyPath' => 'tags[0].priority',
                    'message' => 'This value should be "0" or more.',
                ],
            ],
        ];

        yield 'invalid tags' => [
            'joined@example.com',
            'I am',
            [['name' => 'Satellites', 'priority' => 0]],
            [
                [
                    'propertyPath' => 'tags',
                    'code' => '7ac035d4-2492-4f57-9470-945a7e6a08c1', // tag not found in nomenclature step
                ],
            ],
        ];

        yield 'not enough tags' => [
            'joined@example.com',
            'I am',
            [],
            [
                [
                    'propertyPath' => 'tags',
                    'message' => 'This collection should contain exactly 1 element.',
                ],
            ],
        ];

        yield 'too many tags' => [
            'joined@example.com',
            'I am',
            [
                ['name' => 'A Supplier', 'priority' => 0],
                ['name' => 'A Key Account', 'priority' => 1],
            ],
            [
                [
                    'propertyPath' => 'tags',
                    'message' => 'This collection should contain exactly 1 element.',
                ],
            ],
        ];
    }

    protected function getCommunity(string $name): Community
    {
        if (self::$container === null) {
            self::$client = static::createClient();
        }

        $communityRepository = self::$container->get(CommunityRepository::class);

        return $communityRepository->findOneByName($name);
    }

    private function getMember(string $email, Community $community): Member
    {
        $accountRepository = self::$container->get(AccountRepository::class);

        /** @var Account $account */
        $account = $accountRepository->findOneByEmail($email);

        return $account->getMemberFor($community);
    }

    private function getTagId(string $name): ?int
    {
        /** @var EntityRepository<Tag> $tagRepository */
        $tagRepository = self::$container->get(ManagerRegistry::class)->getRepository(Tag::class);
        $queryBuilder = $tagRepository->createQueryBuilder('tag');
        $queryBuilder
            ->innerJoin('tag.translations', 'translation')
            ->where('translation.label = :label')
            ->andWhere('translation.locale = :locale')
            ->setParameter('label', $name)
            ->setParameter('locale', 'en')
        ;

        $tag = $queryBuilder->getQuery()->getOneOrNullResult();

        if ($tag !== null) {
            return $tag->getId();
        }

        return null;
    }
}
