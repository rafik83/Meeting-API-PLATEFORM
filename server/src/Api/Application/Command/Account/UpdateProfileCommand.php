<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account;

use Proximum\Vimeet365\Api\Application\ContextAwareMessageInterface;
use Proximum\Vimeet365\Api\Infrastructure\Validator\Constraints\Account\JobPositionNomenclatureExists;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateProfileCommand implements ContextAwareMessageInterface
{
    /** @Ignore */
    private Account $member;

    /**
     * @var int|null a Tag id
     *
     * @JobPositionNomenclatureExists
     *
     * @todo doit appartenir a la nomenclature des fonctions
     */
    public ?int $jobPosition = null;

    /**
     * @Assert\Length(max=255)
     */
    public ?string $jobTitle = null;

    /**
     * @var string[]
     *
     * @Assert\All({@Assert\Language()})
     * @Assert\Count(min=1, max=3)
     */
    public array $languages = [];

    /**
     * @Assert\Country
     * @Assert\NotBlank
     */
    public ?string $country = null;

    /**
     * @Assert\Timezone
     * @Assert\NotBlank
     */
    public ?string $timezone = null;

    public function setContext(object $object): void
    {
        if (!$object instanceof Account) {
            throw new \RuntimeException(sprintf('Can only be called with an %s object', Account::class));
        }

        $this->member = $object;
    }

    public function getAccount(): Account
    {
        return $this->member;
    }
}
