<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\API\Application\Command\Account;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Api\Application\Command\Account\ValidationCommand;
use Proximum\Vimeet365\Api\Application\Command\Account\ValidationCommandHandler;
use Proximum\Vimeet365\Core\Application\Mail\AccountValidationMailerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Security\AccountValidationTokenStorageInterface;

class ValidationCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testShouldSendAnEmailWithAGeneratedToken(): void
    {
        $userId = 1;

        $token = 'my-token';

        $origin = 'http://hello.world';

        $account = $this->prophesize(Account::class);
        $account->getId()->willReturn($userId);

        $tokenStorage = $this->prophesize(AccountValidationTokenStorageInterface::class);
        $tokenStorage->generateToken($account->reveal())->shouldBeCalled()->willReturn($token);

        $mailer = $this->prophesize(AccountValidationMailerInterface::class);
        $mailer->send($account->reveal(), $token, $origin)->shouldBeCalled();

        $command = new ValidationCommand($account->reveal(), $origin);

        $handler = new ValidationCommandHandler($tokenStorage->reveal(), $mailer->reveal());
        $handler($command);
    }
}
