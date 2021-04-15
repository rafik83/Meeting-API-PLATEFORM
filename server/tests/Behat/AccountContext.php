<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Tests\Behat;

use Behat\Behat\Context\Context;
use Proximum\Vimeet365\Application\Adapter\CommandBusInterface;
use Proximum\Vimeet365\Application\Command\Account\RegistrationCommand;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class AccountContext implements Context
{
    private CommandBusInterface $bus;

    public function __construct(CommandBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @Given the user :email is created
     */
    public function create(string $email)
    {
        $command = new RegistrationCommand();
        $command->firstName = 'John';
        $command->lastName = 'Doe';
        $command->email = $email;
        $command->password = 'password';
        $command->acceptedTermsAndCondition = true;

        $this->bus->handle($command);
    }
}
