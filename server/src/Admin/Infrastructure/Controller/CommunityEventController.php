<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Controller;

use Proximum\Vimeet365\Admin\Application\Command\Community\Event\CreateCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\DeleteCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Event\EditCommand;
use Proximum\Vimeet365\Admin\Application\Query\Community\Event\ListQuery;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityEvent\FilterType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityEvent\FormType;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/community/{communityId}/events", name="admin_community_event")
 * @Entity("community", expr="repository.find(communityId)")
 */
class CommunityEventController extends AbstractController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {
    }

    /**
     * @Route("", name="_list")
     */
    public function list(Request $request, Pagination $pagination, Community $community): Response
    {
        if (!$this->isFeatureAvailable($community)) {
            return $this->render('admin/communityEvent/notAvailable.html.twig', ['community' => $community]);
        }

        $filtersForm = $this->createForm(FilterType::class, []);

        $filtersForm->handleRequest($request);

        if ($request->query->has('sort')) {
            $sort = (string) $request->query->get('sort');
        }

        $pagination = $this->queryBus->handle(
            new ListQuery(
                $pagination,
                array_merge($filtersForm->getData(), ['community' => $community]),
                $sort ?? null,
                (string) $request->query->get('sortDirection', 'ASC')
            )
        );

        return $this->render('admin/communityEvent/list.html.twig', [
            'community' => $community,
            'pagination' => $pagination,
            'filtersForm' => $filtersForm->createView(),
        ]);
    }

    /**
     * @Route("/create", name="_create")
     */
    public function create(Request $request, Community $community): Response
    {
        if (!$this->isFeatureAvailable($community)) {
            return $this->render('admin/communityEvent/notAvailable.html.twig', ['community' => $community]);
        }

        $form = $this->createForm(FormType::class, new CreateCommand($community), [
            'community' => $community,
            'create' => true,
        ]);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.community_event.create.flash.success');

            return $this->redirectToRoute('admin_community_event_list', ['communityId' => $community->getId()]);
        }

        return $this->render('admin/communityEvent/create.html.twig', [
            'form' => $form->createView(),
            'community' => $community,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="_edit")
     * @Entity("event", expr="repository.findOneByIdAndCommunity(id, communityId)")
     */
    public function edit(Request $request, Community $community, Event $event): Response
    {
        if (!$this->isFeatureAvailable($community)) {
            return $this->render('admin/communityEvent/notAvailable.html.twig', ['community' => $community]);
        }

        $form = $this->createForm(FormType::class, new EditCommand($event), ['community' => $community]);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.community_event.edit.flash.success');

            return $this->redirectToRoute('admin_community_event_list', ['communityId' => $community->getId()]);
        }

        return $this->render('admin/communityEvent/edit.html.twig', [
            'form' => $form->createView(),
            'community' => $community,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="_delete")
     * @Entity("event", expr="repository.findOneByIdAndCommunity(id, communityId)")
     */
    public function delete(Community $community, Event $event): RedirectResponse
    {
        $this->commandBus->handle(new DeleteCommand($event));

        $this->addFlash('success', 'admin.community_event.delete.flash.success');

        return $this->redirectToRoute('admin_community_event_list', ['communityId' => $community->getId()]);
    }

    /**
     * Check if the Community Event feature can be use with this community configuration
     */
    private function isFeatureAvailable(Community $community): bool
    {
        return $community->isEventFeatureAvailable();
    }
}
