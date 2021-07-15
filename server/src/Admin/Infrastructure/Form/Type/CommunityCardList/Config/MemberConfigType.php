<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\CommunityCardList\Config;

use Proximum\Vimeet365\Admin\Application\Command\Community\CardList\MemberConfigDto;
use Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Community\NomenclatureTagType;
use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mainGoal', NomenclatureTagType::class, [
                'required' => false,
                'nomenclature' => $options['community']->getMainGoal()->getNomenclature(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('data_class', MemberConfigDto::class)
            ->setDefault('empty_data', fn (Options $options) => new MemberConfigDto($options['community'], null))
            ->setRequired('community')
            ->setAllowedTypes('community', Community::class)
        ;
    }
}
