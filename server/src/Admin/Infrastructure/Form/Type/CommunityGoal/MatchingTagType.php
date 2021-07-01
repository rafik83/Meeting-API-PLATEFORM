<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityGoal;

use Proximum\Vimeet365\Admin\Application\Dto\Community\Goal\MatchingGoalDto;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchingTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $goal = $options['goal'];

        $builder
            ->add('from', GoalTagType::class, [
                'goal' => $goal,
            ])
            ->add('to', GoalTagType::class, [
                'goal' => $goal,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('data_class', MatchingGoalDto::class)
            ->setDefault('empty_data', fn (Options $options) => new MatchingGoalDto($options['goal']))
            ->setRequired('goal')
            ->setAllowedTypes('goal', Goal::class)
        ;
    }
}
