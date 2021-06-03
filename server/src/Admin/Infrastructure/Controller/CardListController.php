<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Controller;

use Proximum\Vimeet365\Admin\Application\Command\CardList\CreateCommand;
use Proximum\Vimeet365\Admin\Application\Command\CardList\EditCommand;
use Proximum\Vimeet365\Admin\Application\Query\CardList\ListQuery;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CardList\CardListType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Nomenclature\FilterType;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Core\Domain\Entity\Card\CardList;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/card-list/community/{communityId}", name="admin_card_list")
 * @Entity("community", expr="repository.find(communityId)")
 */
class CardListController extends AbstractController
{
    public function __construct(private CommandBusInterface $commandBus, private QueryBusInterface $queryBus)
    {
    }

    /**
     * @Route("", name="_list")
     */
    public function list(Pagination $pagination, Request $request, Community $community): Response
    {
        $filtersForm = $this->createForm(FilterType::class, []);

        $filtersForm->handleRequest($request);

        $pagination = $this->queryBus->handle(
            new ListQuery(
                $pagination,
                array_merge($filtersForm->getData(), ['community' => $community]),
                $request->query->get('sort'),
                $request->query->get('sortDirection', 'ASC')
            )
        );

        return $this->render('admin/cardList/list.html.twig', [
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
        $form = $this->createForm(CardListType::class, new CreateCommand($community));

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.nomenclature.create.success');

            return $this->redirectToRoute('admin_card_list_list', ['communityId' => $community->getId()]);
        }

        return $this->render('admin/cardList/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
     * @Entity("cardList", expr="repository.find(id)")
     */
    public function edit(Request $request, Community $community, CardList $cardList): Response
    {
        $form = $this->createForm(CardListType::class, new EditCommand($cardList));

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $cardList = $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.nomenclature.create.success');

            return $this->redirectToRoute('admin_card_list_list', ['communityId' => $community->getId()]);
        }

        return $this->render('admin/cardList/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
