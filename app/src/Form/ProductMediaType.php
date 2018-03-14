<?php

declare(strict_types=1);

namespace App\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\ProductMedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', TranslationsType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductMedia::class,
        ]);
    }
}
