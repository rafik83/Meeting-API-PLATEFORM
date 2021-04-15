<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Application\Command\Account\Company;

use Proximum\Vimeet365\Application\ContextAwareMessageInterface;
use Proximum\Vimeet365\Domain\Entity\Account;
use Proximum\Vimeet365\Domain\Entity\Company;
use Proximum\Vimeet365\Infrastructure\Validator\Constraints\EntityReferenceExists;
use Symfony\Component\Serializer\Annotation\Ignore;

class LinkCommand implements ContextAwareMessageInterface
{
    /**
     * @EntityReferenceExists(entity=Company::class, identityField="id", message="The company doesn't exist")
     */
    public int $company;

    /** @Ignore */
    public Account $account;

    public function setContext(object $object): void
    {
        if (!$object instanceof Account) {
            throw new \RuntimeException('can only be used on account object');
        }

        $this->account = $object;
    }
}
