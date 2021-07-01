<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityGoal;

use Proximum\Vimeet365\Admin\Application\Dto\Community\Goal\RefinedGoalDto;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RefineGoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $goal = $options['goal'];

        $builder
            ->add('refinedGoals', CollectionType::class, [
                'entry_type' => RefinedGoalType::class,
                'entry_options' => [
                    'goal' => $goal,
                    'empty_data' => new RefinedGoalDto($goal),
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ]);

        $builder->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('goal')
            ->setAllowedTypes('goal', Goal::class)
        ;
    }
}
