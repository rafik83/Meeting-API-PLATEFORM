<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Controller;

use Proximum\Vimeet365\Admin\Application\Command\Community\Media\CreateCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Media\DeleteCommand;
use Proximum\Vimeet365\Admin\Application\Command\Community\Media\EditCommand;
use Proximum\Vimeet365\Admin\Application\Query\Community\Media\ListQuery;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityMedia\FilterType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityMedia\FormType;
use Proximum\Vimeet365\Common\Messenger\CommandBusInterface;
use Proximum\Vimeet365\Common\Messenger\QueryBusInterface;
use Proximum\Vimeet365\Common\Pagination\Pagination;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Media;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/community/{communityId}/medias", name="admin_community_media")
 * @Entity("community", expr="repository.find(communityId)")
 */
class CommunityMediaController extends AbstractController
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
            return $this->render('admin/communityMedia/notAvailable.html.twig', ['community' => $community]);
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

        return $this->render('admin/communityMedia/list.html.twig', [
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
            return $this->render('admin/communityMedia/notAvailable.html.twig', ['community' => $community]);
        }

        $form = $this->createForm(FormType::class, new CreateCommand($community), [
            'community' => $community,
            'create' => true,
        ]);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.community_media.create.flash.success');

            return $this->redirectToRoute('admin_community_media_list', ['communityId' => $community->getId()]);
        }

        return $this->render('admin/communityMedia/create.html.twig', [
            'form' => $form->createView(),
            'community' => $community,
            'published' => null,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="_edit")
     * @Entity("media", expr="repository.findOneByIdAndCommunity(id, communityId)")
     */
    public function edit(Request $request, Community $community, Media $media): Response
    {
        if (!$this->isFeatureAvailable($community)) {
            return $this->render('admin/communityMedia/notAvailable.html.twig', ['community' => $community]);
        }

        $form = $this->createForm(FormType::class, new EditCommand($media), ['community' => $community]);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($form->getData());

            $this->addFlash('success', 'admin.community_media.edit.flash.success');

            return $this->redirectToRoute('admin_community_media_list', ['communityId' => $community->getId()]);
        }

        return $this->render('admin/communityMedia/edit.html.twig', [
            'form' => $form->createView(),
            'community' => $community,
            'published' => $media->isPublished(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="_delete")
     * @Entity("media", expr="repository.findOneByIdAndCommunity(id, communityId)")
     */
    public function delete(Community $community, Media $media): RedirectResponse
    {
        $this->commandBus->handle(new DeleteCommand($media));

        $this->addFlash('success', 'admin.community_media.delete.flash.success');

        return $this->redirectToRoute('admin_community_media_list', ['communityId' => $community->getId()]);
    }

    /**
     * Check if the Community Media feature can be use with this community configuration
     */
    private function isFeatureAvailable(Community $community): bool
    {
        return $community->isMediaFeatureAvailable();
    }
}
