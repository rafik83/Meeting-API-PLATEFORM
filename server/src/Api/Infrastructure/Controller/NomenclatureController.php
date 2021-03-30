<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\Controller;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Repository\NomenclatureRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NomenclatureController
{
    public function getJobPosition(NomenclatureRepositoryInterface $nomenclatureRepository): Nomenclature
    {
        $nomenclature = $nomenclatureRepository->findJobPositionNomenclature();

        if ($nomenclature === null) {
            throw new NotFoundHttpException(
                sprintf('Unable to find the nomenclature with reference "%s"', Nomenclature::JOB_POSITION_NOMENCLATURE)
            );
        }

        return $nomenclature;
    }
}
