<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityEvent;

use Elao\Enum\Bridge\Symfony\Form\Type\EnumType;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community\NomenclatureTagType;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Proximum\Vimeet365\Core\Domain\Entity\Community\EventType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => '',
                'label' => 'admin.community_event.form.name.label',
            ])
            ->add('eventType', EnumType::class, [
                'enum_class' => EventType::class,
                'label' => 'admin.community_event.form.type.label',
            ])
            ->add('startDate', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'label' => 'admin.community_event.form.start_date.label',
            ])
            ->add('endDate', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'label' => 'admin.community_event.form.end_date.label',
            ])
            ->add('registerUrl', UrlType::class, [
                'empty_data' => '',
                'label' => 'admin.community_event.form.register_url.label',
            ])
            ->add('findOutMoreUrl', UrlType::class, [
                'empty_data' => '',
                'label' => 'admin.community_event.form.find_out_more_url.label',
            ])
            ->add('picture', FileType::class, [
                'attr' => ['accept' => 'image/jpeg,image/png'],
                'required' => false,
                'label' => 'admin.community_event.form.picture.label',
                'help' => 'admin.community_event.form.picture.help',
            ])
            ->add('tags', NomenclatureTagType::class, [
                'nomenclature' => $options['community']->getEventNomenclature(),
                'multiple' => true,
                'label' => 'admin.community_event.form.tags.label',
                'help' => 'admin.community_event.form.tags.help',
                'required' => false,
            ])
            ->add('characterizationTags', NomenclatureTagType::class, [
                'nomenclature' => $options['community']->getSkillNomenclature(),
                'multiple' => true,
                'label' => 'admin.community_event.form.characterization_tags.label',
                'required' => false,
            ])
            ->add('published', CheckboxType::class, [
                'required' => false,
                'label' => 'admin.community_event.form.published.label',
            ])
        ;

        $builder->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('create', false)
            ->setRequired('community')
            ->setAllowedTypes('community', Community::class)
            ->setAllowedTypes('create', 'bool')
        ;
    }
}
