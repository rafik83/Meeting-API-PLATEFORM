<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Controller;

use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\RefineMainGoalCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\SetMainGoalCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Goal\SetMatchingGoalsCommand;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community\MainGoalType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityGoal\GoalMatchingsType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityGoal\RefineGoalType;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/community", name="admin_community")
 */
class CommunityGoalController extends AbstractController
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    /**
     * @Route("/{id}/main-goal", name="_main_goal")
     */
    public function editGoal(Request $request, Community $community): Response
    {
        $command = new SetMainGoalCommand($community);

        $form = $this->createForm(MainGoalType::class, $command, ['community' => $community]);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($form->getData());

            return $this->redirectToRoute('admin_community_main_goal', ['id' => $community->getId()]);
        }

        if ($community->getMainGoal() !== null) {
            $refineGoalForm = $this->createForm(
                RefineGoalType::class,
                new RefineMainGoalCommand($community->getMainGoal()),
                ['goal' => $community->getMainGoal()]
            );

            if ($refineGoalForm->handleRequest($request)->isSubmitted() && $refineGoalForm->isValid()) {
                $this->commandBus->handle($refineGoalForm->getData());

                return $this->redirectToRoute('admin_community_main_goal', ['id' => $community->getId()]);
            }

            $matchingForm = $this->createForm(
                GoalMatchingsType::class,
                new SetMatchingGoalsCommand($community->getMainGoal()),
                ['goal' => $community->getMainGoal()]
            );

            if ($matchingForm->handleRequest($request)->isSubmitted() && $matchingForm->isValid()) {
                $this->commandBus->handle($matchingForm->getData());

                return $this->redirectToRoute('admin_community_main_goal', ['id' => $community->getId()]);
            }
        }

        return $this->render('admin/communityGoal/mainGoal.html.twig', [
            'form' => $form->createView(),
            'refineGoalForm' => isset($refineGoalForm) ? $refineGoalForm->createView() : null,
            'matchingForm' => isset($matchingForm) ? $matchingForm->createView() : null,
            'community' => $community,
        ]);
    }
}
