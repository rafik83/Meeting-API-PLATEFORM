<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Proximum\Vimeet365\Application\View\AccountView;
use Proximum\Vimeet365\Domain\Entity\Account;

class AccountOutputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     *
     * @param object|Account $data
     */
    public function transform($data, string $to, array $context = []): AccountView
    {
        if (!$data instanceof Account) {
            throw new \RuntimeException(
                sprintf('Should only be called with %s instances, %s given', Account::class, \get_class($data))
            );
        }

        return new AccountView(
            (int) $data->getId(),
            $data->getEmail(),
            $data->getFirstName(),
            $data->getLastName(),
            $data->getAcceptedTermsAndConditionAt(),
            $data->getAvatar(),
            $data->getCompany()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return AccountView::class === $to && $data instanceof Account;
    }
}
