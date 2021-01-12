<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Adapter;

use Proximum\Vimeet365\Application\Adapter\CommandBusInterface;
use Proximum\Vimeet365\Application\Adapter\QueryBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class BusAdapter implements QueryBusInterface, CommandBusInterface
{
    use HandleTrait {
        handle as doHandle;
    }

    /** @var MessageBusInterface */
    private $messageBus;

    public function __construct(MessageBusInterface $commandMessageBus)
    {
        $this->messageBus = $commandMessageBus;
    }

    /**
     * @return mixed|object|void
     */
    public function handle(object $message)
    {
        try {
            return $this->doHandle($message);
        } catch (HandlerFailedException $exception) {
            $previous = $exception->getPrevious();

            if ($previous === null) {
                throw $exception;
            }

            throw $previous;
        }
    }
}
