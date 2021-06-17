<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NomenclatureChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('community')
            ->setAllowedTypes('community', Community::class)
            ->setDefaults([
                'class' => Nomenclature::class,
                'query_builder' => function (Options $options): \Closure {
                    return static function (EntityRepository $entityRepository) use ($options): QueryBuilder {
                        $queryBuilder = $entityRepository->createQueryBuilder('nomenclature');
                        $queryBuilder
                            ->andWhere('nomenclature.community = :community')
                            ->setParameter('community', $options['community']);

                        return $queryBuilder;
                    };
                },
            ])
        ;
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
