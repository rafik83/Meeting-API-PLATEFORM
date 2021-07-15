<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Core\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Member;
use Proximum\Vimeet365\Core\Infrastructure\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MemberRepositoryTest extends KernelTestCase
{
    use RefreshDatabaseTrait;
    use ProphecyTrait;

    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testSortedByDate(): void
    {
        $communityRepository = $this->entityManager->getRepository(Community::class);
        $community = $communityRepository->findOneBy(['name' => 'Space industry']);

        /** @var MemberRepository $companyRepository */
        $companyRepository = $this->entityManager->getRepository(Member::class);

        /** @var Member[] $members */
        $members = $companyRepository->getSortedByDate($community, null, 2);

        self::assertCount(2, $members);
        self::assertEquals('member@example.com', $members[0]->getAccount()->getEmail());
    }

    public function testSortedByName(): void
    {
        $communityRepository = $this->entityManager->getRepository(Community::class);
        $community = $communityRepository->findOneBy(['name' => 'Space industry']);

        /** @var MemberRepository $companyRepository */
        $companyRepository = $this->entityManager->getRepository(Member::class);
        $members = $companyRepository->getSortedByName($community, null, 2);

        self::assertCount(2, $members);
        self::assertEquals('member@example.com', $members[0]->getAccount()->getEmail());
    }

    public function testSortedByNameWithGoal(): void
    {
        $communityRepository = $this->entityManager->getRepository(Community::class);
        /** @var Community $community */
        $community = $communityRepository->findOneBy(['name' => 'Space industry']);

        $tag = $community->getMainGoal()->getNomenclature()->getTags()->first()->getTag();

        $memberConfig = $this->prophesize(Community\CardList\MemberConfig::class);
        $memberConfig->getMainGoal()->willReturn($tag);

        /** @var MemberRepository $companyRepository */
        $companyRepository = $this->entityManager->getRepository(Member::class);
        $members = $companyRepository->getSortedByName($community, $memberConfig->reveal(), 2);

        self::assertCount(1, $members);
        self::assertEquals('member@example.com', $members[0]->getAccount()->getEmail());
    }
}
