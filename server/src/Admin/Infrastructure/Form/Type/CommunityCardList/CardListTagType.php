<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityCardList;

use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\TagDto;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community\NomenclatureTagType;
use Proximum\Vimeet365\Core\Domain\Entity\Nomenclature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardListTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tag', NomenclatureTagType::class, ['nomenclature' => $options['nomenclature']])
            ->add('position', NumberType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('data_class', TagDto::class)
            ->setRequired('nomenclature')
            ->setAllowedTypes('nomenclature', Nomenclature::class)
        ;
    }
}
