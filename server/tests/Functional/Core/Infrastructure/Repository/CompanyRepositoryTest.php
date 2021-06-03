<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Core\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Company;
use Proximum\Vimeet365\Core\Infrastructure\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CompanyRepositoryTest extends KernelTestCase
{
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

        /** @var CompanyRepository $companyRepository */
        $companyRepository = $this->entityManager->getRepository(Company::class);
        $companies = $companyRepository->getSortedByDate($community, 2);

        self::assertCount(1, $companies);
        self::assertEquals('Proximum', $companies[0]->getName());
    }

    public function testSortedByName(): void
    {
        $communityRepository = $this->entityManager->getRepository(Community::class);
        $community = $communityRepository->findOneBy(['name' => 'Space industry']);

        /** @var CompanyRepository $companyRepository */
        $companyRepository = $this->entityManager->getRepository(Company::class);
        $companies = $companyRepository->getSortedByName($community, 2);

        self::assertCount(1, $companies);
        self::assertEquals('Proximum', $companies[0]->getName());
    }
}
