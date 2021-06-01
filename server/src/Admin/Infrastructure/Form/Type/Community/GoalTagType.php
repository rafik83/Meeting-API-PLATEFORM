<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community;

use Proximum\Vimeet365\Core\Domain\Entity\Community\Goal;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Infrastructure\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoalTagType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'class' => Tag::class,
                'required' => true,
                'query_builder' => function (Options $options): \Closure {
                    $nomenclature = $options['goal']->getNomenclature();

                    return static fn (TagRepository $repository) => $repository->getTagThatBelongToANomenclatureQueryBuilder($nomenclature);
                },
                'choice_label' => function (Options $options): \Closure {
                    $community = $options['goal']->getCommunity();
                    /** @var Nomenclature $nomenclature */
                    $nomenclature = $options['goal']->getNomenclature();

                    return static function (Tag $tag) use ($nomenclature, $community): ?string {
                        $nomenclatureTag = $nomenclature->findTag($tag);

                        if ($nomenclatureTag === null) {
                            return $tag->getLabel($community->getDefaultLanguage());
                        }

                        return $nomenclatureTag->getLabel($community->getDefaultLanguage());
                    };
                },
            ])
            ->setRequired('goal')
            ->setAllowedTypes('goal', Goal::class);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
