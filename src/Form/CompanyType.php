<?php

declare(strict_types=1);

namespace App\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsFormsType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsLocalesSelectorType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = null !== $options['data']?->id;

        $builder
            ->add('code')
            ->add('translations', TranslationsType::class, [
                'translatable_class' => $options['data_class'],
            ])
            ->add('categories', CollectionType::class, [
                'entry_type' => CategoryType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => [
                    'data-entry-add-label' => 'Add Category',
                    'data-entry-remove-label' => 'Rm Category',
                ],
            ])
            ->add('medias', TranslationsFormsType::class, [
                'form_type' => CompanyMediaType::class,
            ])
            ->add('save', SubmitType::class, [
                'label' => $isEdit ? 'Edit' : 'Create',
                'attr' => [
                    'class' => 'btn-primary btn-lg btn-block',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
