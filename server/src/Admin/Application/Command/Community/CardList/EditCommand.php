<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
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

    /** @var Tag[] */
    public array $tags = [];

    public bool $published;

    public function __construct(public CardList $cardList)
    {
        $this->sorting = $cardList->getSorting();
        $this->position = $cardList->getPosition();
        $this->title = $cardList->getTitle();
        $this->cardTypes = $cardList->getCardTypes();
        $this->tags = $cardList->getTags()->getValues();
        $this->published = $cardList->isPublished();
    }
}
