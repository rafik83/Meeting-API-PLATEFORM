<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Card\Sorting;
use Symfony\Component\Validator\Constraints as Assert;

class EditCommand
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    public string $title = '';
    /**
     * @Assert\NotNull
     */
    public Sorting $sorting;
    public int $position = 0;

    /**
     * @Assert\Count(min=1)
     *
     * @var CardType[]
     */
    public array $cardTypes = [];

    public bool $published;

    public function __construct(public CardList $cardList)
    {
        $this->sorting = $cardList->getSorting();
        $this->position = $cardList->getPosition();
        $this->title = $cardList->getTitle();
        $this->cardTypes = $cardList->getCardTypes();
        $this->published = $cardList->isPublished();
    }
}
