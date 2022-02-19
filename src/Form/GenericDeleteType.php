<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class GenericDeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('DELETE')
            ->add('delete', SubmitType::class, [
                'label' => 'Delete',
                'attr' => [
                    'class' => 'btn-danger btn-lg btn-block',
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'delete';
    }
}
