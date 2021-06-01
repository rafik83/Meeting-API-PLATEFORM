<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community;

use Doctrine\ORM\QueryBuilder;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Infrastructure\Repository\NomenclatureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainGoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $community = $options['community'];

        $builder
            ->add('nomenclature', EntityType::class, [
                'class' => Nomenclature::class,
                'required' => true,
                'query_builder' => function (NomenclatureRepository $repository) use ($community): QueryBuilder {
                    return $repository->getFirstLevelNomenclatureQueryBuilder($community);
                },
            ])
            ->add('min', IntegerType::class, [
                'required' => true,
                'attr' => [
                    'min' => 0,
                ],
            ])
            ->add('max', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 0,
                ],
            ])
        ;

        $builder->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('community')
            ->setAllowedTypes('community', Community::class)
        ;
    }
}
