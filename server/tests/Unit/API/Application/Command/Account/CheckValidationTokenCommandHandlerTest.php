<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Unit\API\Application\Command\Account;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Proximum\Vimeet365\Api\Application\Command\Account\CheckValidationTokenCommand;
use Proximum\Vimeet365\Api\Application\Command\Account\CheckValidationTokenCommandHandler;
use Proximum\Vimeet365\Api\Application\Exception\InvalidTokenException;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Proximum\Vimeet365\Core\Domain\Security\AccountValidationTokenStorageInterface;

class CheckValidationTokenCommandHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testShouldSendAnEmailWithAGeneratedToken(): void
    {
        $token = 'token';

        $account = $this->prophesize(Account::class);
        $account->validate()->shouldBeCalled();

        $tokenStorage = $this->prophesize(AccountValidationTokenStorageInterface::class);
        $tokenStorage->exists($account->reveal(), $token)->shouldBeCalled()->willReturn(true);
        $command = new CheckValidationTokenCommand();

        $command->token = $token;
        $command->setContext($account->reveal());

        $handler = new CheckValidationTokenCommandHandler($tokenStorage->reveal());
        $handler($command);
    }

    public function testShouldReturnExceptionIfTokenInvalid(): void
    {
        $this->expectException(InvalidTokenException::class);
        $token = 'token';

        $account = $this->prophesize(Account::class);
        $account->validate()->shouldNotBeCalled();

        $tokenStorage = $this->prophesize(AccountValidationTokenStorageInterface::class);
        $tokenStorage->exists($account->reveal(), $token)->shouldBeCalled()->willReturn(false);
        $command = new CheckValidationTokenCommand();

        $command->token = $token;
        $command->setContext($account->reveal());

        $handler = new CheckValidationTokenCommandHandler($tokenStorage->reveal());
        $handler($command);
    }
}
