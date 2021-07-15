<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Proximum\Vimeet365\Core\Domain\Entity\Community\CardList;
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
     * @Assert\NotNull
     * @Assert\Range(min="1", max="100")
     */
    public int $limit;

    /**
     * @Assert\Count(min=1)
     *
     * @var CardType[]
     */
    public array $cardTypes = [];

    /** @var TagDto[] */
    public array $tags = [];

    public bool $published;

    /**
     * @Assert\Valid
     *
     * @var array<string, MemberConfigDto|null>
     */
    public array $configs;

    public function __construct(public CardList $cardList)
    {
        $this->sorting = $cardList->getSorting();
        $this->position = $cardList->getPosition();
        $this->limit = $cardList->getLimit();
        $this->title = $cardList->getTitle();
        $this->cardTypes = $cardList->getCardTypes();
        $this->tags = $cardList->getTags()
            ->map(fn (CardList\Tag $cardListTag) => new TagDto($cardListTag->getTag(), $cardListTag->getPosition()))
            ->getValues()
        ;
        $this->published = $cardList->isPublished();

        $this->configs = array_combine(
            CardType::values(),
            array_map(
                fn (CardType $cardType): MemberConfigDto | null => ConfigDto::create($this->cardList->getCommunity(), $this->cardList->getConfig($cardType)),
                CardType::instances()
            )
        );
    }
}
