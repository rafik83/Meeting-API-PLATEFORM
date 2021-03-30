<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Application\Command\Account\Company;

use Proximum\Vimeet365\Api\Application\ContextAwareMessageInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommand implements ContextAwareMessageInterface
{
    /**
     * @Assert\NotBlank
     */
    public string $name = '';

    /**
     * @Assert\Country
     * @Assert\NotBlank
     */
    public string $countryCode = '';

    /**
     * @Assert\Url
     * @Assert\NotBlank
     */
    public string $website = '';

    /**
     * @Assert\Length(max=300)
     */
    public string $activity = '';

    /** @Ignore */
    public Account $account;

    public function setContext(object $object): void
    {
        if (!$object instanceof Account) {
            throw new \RuntimeException('Can only be call from Account resource');
        }
        $this->account = $object;
    }
}
