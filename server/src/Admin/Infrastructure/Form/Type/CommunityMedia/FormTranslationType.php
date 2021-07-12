<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityMedia;

use Proximum\Vimeet365\Admin\Application\Dto\CommunityMedia\TranslationDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $iconName = 'flag-' . trim($options['property_path'], '[]');

        $builder
            ->add('language', HiddenType::class)
            ->add('name', TextType::class, [
                'label' => 'admin.community_media.form.translations.children.name.label',
                'icon' => $iconName,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'admin.community_media.form.translations.children.description.label',
                'attr' => ['data-quill' => true],
                'required' => false,
            ])
            ->add('ctaLabel', TextType::class, [
                'required' => false,
                'label' => 'admin.community_media.form.translations.children.cta_label.label',
                'icon' => $iconName,
            ])
            ->add('ctaUrl', UrlType::class, [
                'required' => false,
                'label' => 'admin.community_media.form.translations.children.cta_url.label',
                'icon' => $iconName,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', TranslationDto::class);
    }
}
