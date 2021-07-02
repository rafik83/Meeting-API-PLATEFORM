<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityCardList;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community\NomenclatureTagType;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\CardType;
use Proximum\Vimeet365\Core\Domain\Entity\Community\Card\Sorting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('sorting', EnumType::class, [
                'enum_class' => Sorting::class,
            ])
            ->add('position', IntegerType::class)
            ->add('cardTypes', EnumType::class, [
                'enum_class' => CardType::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('tags', NomenclatureTagType::class, [
                'nomenclature' => $options['community']->getMainGoal()->getNomenclature(),
                'multiple' => true,
                'label' => 'admin.card_list.form.tags.label',
                'required' => false,
            ])
            ->add('published', CheckboxType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('community')
            ->setAllowedTypes('community', Community::class)
        ;
    }
}
