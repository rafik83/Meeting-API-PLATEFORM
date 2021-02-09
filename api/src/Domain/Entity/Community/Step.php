<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity\Community;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Domain\Entity\Community;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="community_step",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="step_community_nomenclature", columns={"community_id", "nomenclature_id"})
 *      }
 * )
 */
class Step
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class, inversedBy="steps")
     * @ORM\JoinColumn(nullable=false)
     */
    private Community $community;

    /**
     * @ORM\ManyToOne(targetEntity=Nomenclature::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Nomenclature $nomenclature;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $position;

    /**
     * @ORM\Column
     */
    private string $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $min;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private ?int $max;

    public function __construct(
        Community $community,
        Nomenclature $nomenclature,
        int $position,
        string $title,
        ?string $description,
        int $min = 0,
        ?int $max = null
    ) {
        $this->community = $community;
        $this->nomenclature = $nomenclature;
        $this->position = $position;
        $this->title = $title;
        $this->description = $description;
        $this->min = $min;
        $this->max = $max;

        $this->community->getSteps()->set($position, $this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommunity(): Community
    {
        return $this->community;
    }

    public function getNomenclature(): Nomenclature
    {
        return $this->nomenclature;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }
}
