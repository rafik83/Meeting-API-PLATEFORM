<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Application\Card\Provider\SortedByName;

use Proximum\Vimeet365\Core\Application\Card\MemberCard;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardProviderInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Proximum\Vimeet365\Core\Domain\Repository\MemberRepositoryInterface;

class MemberCardProvider implements CardProviderInterface
{
    public function __construct(
        private MemberRepositoryInterface $memberRepository
    ) {
    }

    public function getCards(CardList $cardList): array
    {
        $members = $this->memberRepository->getSortedByName($cardList->getCommunity(), $cardList->getLimit());

        return array_map(static fn (Member $member): MemberCard => new MemberCard($member), $members);
    }

    public function supports(CardList $cardList): bool
    {
        return \count($cardList->getCardTypes()) === 1
            && \in_array(CardType::get(CardType::MEMBER), $cardList->getCardTypes(), true)
            && $cardList->getSorting()->is(Sorting::ALPHABETICAL)
        ;
    }
}
