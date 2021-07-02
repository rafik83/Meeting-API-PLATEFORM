<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Admin\Application\Command\CardList;

use Doctrine\ORM\EntityManager;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\EditCommandHandler;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EditCommandTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

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

    public function testUpdateNewTags(): void
    {
        $cardListRepository = $this->entityManager->getRepository(CardList::class);
        $cardList = $cardListRepository->findOneBy(['title' => 'Very last published events']);

        $command = new EditCommand($cardList);
        $commandHandler = new EditCommandHandler();
        $commandHandler($command);

        $this->entityManager->flush();

        self::assertCount(2, $cardList->getTags());
    }
}
