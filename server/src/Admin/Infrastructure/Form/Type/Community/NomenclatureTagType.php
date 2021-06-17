<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community;

use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Proximum\Vimeet365\Core\Domain\Entity\Tag;
use Proximum\Vimeet365\Core\Infrastructure\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NomenclatureTagType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'class' => Tag::class,
                'required' => true,
                'query_builder' => function (Options $options): \Closure {
                    return static fn (TagRepository $repository) => $repository->getTagThatBelongToANomenclatureQueryBuilder($options['nomenclature']);
                },
                'choice_label' => function (Options $options): \Closure {
                    $nomenclature = $options['nomenclature'];
                    $community = $nomenclature->getCommunity();

                    if ($community === null) {
                        return static fn (Tag $tag) => $tag->getLabel();
                    }

                    return static function (Tag $tag) use ($nomenclature, $community): ?string {
                        $nomenclatureTag = $nomenclature->findTag($tag);

                        if ($nomenclatureTag === null) {
                            return $tag->getLabel($community->getDefaultLanguage());
                        }

                        return $nomenclatureTag->getLabel($community->getDefaultLanguage());
                    };
                },
            ])
            ->setRequired('nomenclature')
            ->setAllowedTypes('nomenclature', [Nomenclature::class]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
