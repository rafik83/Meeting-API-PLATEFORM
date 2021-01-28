<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use Proximum\Vimeet365\Infrastructure\Security\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login")
     */
    public function loginAction(IriConverterInterface $iriConverter): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application/json".',
            ], 400);
        }

        /** @var User|null $user */
        $user = $this->getUser();

        if ($user === null) {
            return $this->json([
                'error' => 'Invalid login request: unable to find the current user.',
            ], 404);
        }

        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromItem($user->getAccount()),
        ]);
    }
}
