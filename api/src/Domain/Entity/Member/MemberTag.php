<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Domain\Entity\Member;

use Doctrine\ORM\Mapping as ORM;
use Proximum\Vimeet365\Domain\Entity\Member;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Domain\Entity\Tag;

/**
 * @ORM\Entity
 */
class MemberTag
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Member::class)
     */
    private Member $member;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Nomenclature::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Nomenclature $nomenclature;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Tag::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Tag $tag;

    public function __construct(Member $member, Nomenclature $nomenclature, Tag $tag)
    {
        $this->member = $member;
        $this->nomenclature = $nomenclature;
        $this->tag = $tag;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getNomenclature(): Nomenclature
    {
        return $this->nomenclature;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }
}
