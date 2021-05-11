<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Controller;

use Proximum\Vimeet365\Admin\Application\Command\Nomenclature\CreateCommand;
use Proximum\Vimeet365\Admin\Application\Command\Nomenclature\EditCommand;
use Proximum\Vimeet365\Admin\Application\Command\Nomenclature\ImportCommand;
use Proximum\Vimeet365\Admin\Application\Query\Nomenclature\ExportQuery;
use Proximum\Vimeet365\Admin\Application\Query\Nomenclature\ListQuery;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Nomenclature\CreateType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Nomenclature\EditType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Nomenclature\FilterType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Nomenclature\ImportType;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

/**
 * @Route("/nomenclature", name="admin_nomenclature")
 */
class NomenclatureController extends AbstractController
{
    private QueryBusInterface $queryBus;
    private CommandBusInterface $commandBus;

    public function __construct(QueryBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("", name="_list")
     */
    public function list(Pagination $pagination, Request $request): Response
    {
        $filtersForm = $this->createForm(FilterType::class, []);

        $filtersForm->handleRequest($request);

        $pagination = $this->queryBus->handle(
            new ListQuery(
                $pagination,
                $filtersForm->getData(),
                $request->query->get('sort'),
                $request->query->get('sortDirection', 'ASC')
            )
        );

        return $this->render('admin/nomenclature/list.html.twig', [
            'pagination' => $pagination,
            'filtersForm' => $filtersForm->createView(),
        ]);
    }

    /**
     * @Route("/create", name="_create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(CreateType::class, new CreateCommand());

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            /** @var Nomenclature $nomenclature */
            $nomenclature = $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.nomenclature.create.success');

            return $this->redirectToRoute('admin_nomenclature_edit', ['id' => $nomenclature->getId()]);
        }

        return $this->render('admin/nomenclature/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="_edit")
     */
    public function edit(Nomenclature $nomenclature, Request $request): Response
    {
        $form = $this->createForm(EditType::class, new EditCommand($nomenclature));
        $importForm = $this->createForm(ImportType::class, new ImportCommand($nomenclature));

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.nomenclature.edit.success');

            return $this->redirectToRoute('admin_nomenclature_edit', ['id' => $nomenclature->getId()]);
        }

        if ($importForm->handleRequest($request)->isSubmitted() && $importForm->isValid()) {
            $this->commandBus->handle($importForm->getData());

            $this->addFlash('success', 'admin.nomenclature.import.success');

            return $this->redirectToRoute('admin_nomenclature_edit', ['id' => $nomenclature->getId()]);
        }

        return $this->render('admin/nomenclature/edit.html.twig', [
            'nomenclature' => $nomenclature,
            'form' => $form->createView(),
            'importForm' => $importForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/export", name="_export")
     */
    public function export(Nomenclature $nomenclature): StreamedResponse
    {
        /** @var \SplFileObject $exportFile */
        $exportFile = $this->queryBus->handle(new ExportQuery($nomenclature));

        $response = new StreamedResponse(function () use ($exportFile): void {
            /** @var string $row */
            foreach ($exportFile as $row) {
                echo $row;
            }

            flush();
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            u($nomenclature->getReference())->ascii()->snake() . '.csv'
        ));

        return $response;
    }
}
