<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Controller;

use Proximum\Vimeet365\Admin\Application\Command\Community\EditCommand;
use Proximum\Vimeet365\Admin\Application\Query\Community\ListQuery;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community\FormType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Nomenclature\FilterType;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/community", name="admin_community")
 */
class CommunityController extends AbstractController
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) {
    }

    /**
     * @Route("", name="_list")
     */
    public function list(Pagination $pagination, Request $request): Response
    {
        $filtersForm = $this->createForm(FilterType::class, []);

        $filtersForm->handleRequest($request);

        if ($request->query->has('sort')) {
            $sort = (string) $request->query->get('sort');
        }

        $pagination = $this->queryBus->handle(
            new ListQuery(
                $pagination,
                $filtersForm->getData(),
                $sort ?? null,
                (string) $request->query->get('sortDirection', 'ASC')
            )
        );

        return $this->render('admin/community/list.html.twig', [
            'pagination' => $pagination,
            'filtersForm' => $filtersForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="_edit")
     */
    public function edit(Request $request, Community $community): Response
    {
        $command = new EditCommand($community);

        $form = $this->createForm(FormType::class, $command, ['community' => $community]);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.community.edit.flash.success');

            return $this->redirectToRoute('admin_community_edit', ['id' => $community->getId()]);
        }

        return $this->render('admin/community/edit.html.twig', [
            'form' => $form->createView(),
            'community' => $community,
        ]);
    }
}
