<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoalTagType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'nomenclature' => function (Options $options): Nomenclature {
                    return $options['goal']->getNomenclature();
                },
            ])
            ->setRequired('goal')
            ->setAllowedTypes('goal', Goal::class);
    }

    public function getParent(): string
    {
        return NomenclatureTagType::class;
    }
}
