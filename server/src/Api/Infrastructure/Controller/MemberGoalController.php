<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Controller;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Proximum\Vimeet365\Api\Application\Command\Member\RankGoalsCommand;
use Proximum\Vimeet365\Api\Application\Command\Member\SetGoalsCommand;
use Proximum\Vimeet365\Api\Application\Query\Member\GetGoalsQuery;
use Proximum\Vimeet365\Api\Application\View\Goal\MemberGoalView;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Member;
use Symfony\Component\Messenger\Exception\ValidationFailedException;

class MemberGoalController
{
    private QueryBusInterface $queryBus;
    private CommandBusInterface $commandBus;

    public function __construct(QueryBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @return MemberGoalView[]
     */
    public function getGoals(Member $data): array
    {
        return $this->queryBus->handle(new GetGoalsQuery($data));
    }

    /**
     * @return MemberGoalView[]
     */
    public function updateGoals(SetGoalsCommand $data): array
    {
        try {
            $member = $this->commandBus->handle($data);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }

        return $this->queryBus->handle(new GetGoalsQuery($member));
    }

    /**
     * @return MemberGoalView[]
     */
    public function rankGoals(RankGoalsCommand $data): array
    {
        try {
            $member = $this->commandBus->handle($data);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }

        return $this->queryBus->handle(new GetGoalsQuery($member));
    }
}
