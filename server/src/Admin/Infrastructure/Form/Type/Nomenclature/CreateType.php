<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Admin\Infrastructure\Form\Type\Nomenclature;

use Proximum\Vimeet365\Core\Domain\Entity\Community;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('community', EntityType::class, [
                'class' => Community::class,
                'required' => false,
            ])
            ->add('reference', TextType::class, [
                'required' => true,
                'empty_data' => '',
            ])
        ;
    }
}
