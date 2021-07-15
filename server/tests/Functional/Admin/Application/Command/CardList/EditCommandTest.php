<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Functional\Admin\Application\Command\CardList;

use Doctrine\ORM\EntityManager;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\EditCommandHandler;
use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\MemberConfigDto;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
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

    public function testCustomMemberConfig(): void
    {
        $cardListRepository = $this->entityManager->getRepository(CardList::class);
        /** @var CardList $cardList */
        $cardList = $cardListRepository->findOneBy(['title' => 'Last users registered']);

        $communityMainGoal = $cardList->getCommunity()->getMainGoal();
        $tag = $communityMainGoal->getNomenclature()->getTags()->first()->getTag();

        self::assertNull($cardList->getConfig(CardType::get(CardType::MEMBER)));

        $command = new EditCommand($cardList);
        $command->configs[CardType::MEMBER] = new MemberConfigDto($cardList->getCommunity(), $tag);
        $commandHandler = new EditCommandHandler();
        $commandHandler($command);

        $this->entityManager->flush();

        self::assertNotNull($cardList->getConfig(CardType::get(CardType::MEMBER)));
        self::assertEquals($tag->getId(), $cardList->getConfig(CardType::get(CardType::MEMBER))->getMainGoal()->getId());
    }
}
