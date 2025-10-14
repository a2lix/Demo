<?php

declare(strict_types=1);

namespace App\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateRangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startAt', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label' => 'Débute',
                'attr' => ['class' => 'form-grid'],
            ])
            ->add('endAt', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label' => 'Prend fin',
                'attr' => ['class' => 'form-grid'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }
}
