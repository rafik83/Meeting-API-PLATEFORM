<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community;

use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'admin.community.form.name.label'])
            ->add('languages', SupportedLanguageType::class, ['multiple' => true, 'label' => 'admin.community.form.languages.label'])
            ->add('defaultLanguage', SupportedLanguageType::class, [
                'label' => 'admin.community.form.default_language.label',
                'help' => 'admin.community.form.default_language.help',
            ])
        ;

        if ($options['community'] !== null) {
            $builder
                ->add('skillNomenclature', NomenclatureChoiceType::class, [
                    'community' => $options['community'],
                    'label' => 'admin.community.form.skill_nomenclature.label',
                    'help' => 'admin.community.form.skill_nomenclature.help',
                    'required' => false,
                ])
                ->add('eventNomenclature', NomenclatureChoiceType::class, [
                    'community' => $options['community'],
                    'label' => 'admin.community.form.event_nomenclature.label',
                    'help' => 'admin.community.form.event_nomenclature.help',
                    'required' => false,
                ])
            ;
        }

        $builder->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('community', null)
            ->setAllowedTypes('community', ['null', Community::class])
        ;
    }
}
