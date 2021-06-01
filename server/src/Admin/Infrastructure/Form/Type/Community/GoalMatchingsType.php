<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community;

use Proximum\Vimeet365\Admin\Application\Command\Community\SetMatchingGoalsCommand;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoalMatchingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $goal = $options['goal'];

        $builder
            ->add('matchingTags', CollectionType::class, [
                'entry_type' => MatchingTagType::class,
                'entry_options' => [
                    'goal' => $goal,
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ]);

        $builder->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('data_class', SetMatchingGoalsCommand::class)
            ->setRequired('goal')
            ->setAllowedTypes('goal', Community\Goal::class)
        ;
    }
}
