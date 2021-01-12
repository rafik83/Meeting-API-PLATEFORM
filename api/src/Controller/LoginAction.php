<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginAction
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['status' => 'not implemented yet']);
    }
}
