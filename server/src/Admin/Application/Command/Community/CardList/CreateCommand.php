<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Application\Command\Community\CardList;

use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommand
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    public string $title = '';

    /**
     * @Assert\NotNull
     */
    public ?Sorting $sorting = null;

    public int $position = 0;

    /**
     * @Assert\Count(min=1)
     *
     * @var CardType[]
     */
    public array $cardTypes = [];

    public bool $published = false;

    public function __construct(private Community $community)
    {
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }
}
