<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityMedia;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community\NomenclatureTagType;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Community $community */
        $community = $options['community'];

        $builder
            ->add('translations', CollectionType::class, [
                'entry_type' => FormTranslationType::class,
                'allow_add' => false,
                'allow_delete' => false,
                'label' => 'admin.community_media.form.translations.label',
            ])
            ->add('mediaType', EnumType::class, [
                'enum_class' => Community\Media\MediaType::class,
                'label' => 'admin.community_media.form.type.label',
            ])
            ->add('tags', NomenclatureTagType::class, [
                'multiple' => true,
                'nomenclature' => $community->getSkillNomenclature(),
                'required' => false,
                'label' => 'admin.community_media.form.tags.label',
                'help' => 'admin.community_media.form.tags.help',
            ])
            ->add('video', FileType::class, [
                'required' => $options['create'],
                'label' => 'admin.community_media.form.video.label',
                'help' => 'admin.community_media.form.video.help',
                'attr' => ['accept' => 'video/mp4'],
            ])
            ->add('published', CheckboxType::class, [
                'required' => false,
                'label' => 'admin.community_media.form.published.label',
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('create', false)
            ->setAllowedTypes('create', 'bool')
            ->setRequired('community')
            ->setAllowedTypes('community', Community::class);
    }
}
