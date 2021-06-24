<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityGoal;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Proximum\Vimeet365\Admin\Application\Dto\Community\Goal\RefinedGoalDto;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RefinedGoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $goal = $options['goal'];
        $community = $goal->getCommunity();

        $builder
            ->add('tag', GoalTagType::class, [
                'goal' => $goal,
            ])
            ->add('nomenclature', EntityType::class, [
                'class' => Nomenclature::class,
                'required' => true,
                'query_builder' => function (EntityRepository $entityRepository) use ($community): QueryBuilder {
                    $queryBuilder = $entityRepository->createQueryBuilder('nomenclature');
                    $queryBuilder
                        ->andWhere('nomenclature.community = :community')
                        ->setParameter('community', $community);

                    return $queryBuilder;
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('data_class', RefinedGoalDto::class)
            ->setRequired('goal')
            ->setAllowedTypes('goal', Goal::class)
        ;
    }
}
