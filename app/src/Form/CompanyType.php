<?php

declare(strict_types=1);

namespace App\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsFormsType;
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
        $builder
            ->add('code')
            ->add('translations', TranslationsType::class, [
                'fields' => [
                    'description' => [
                        'disabled' => true,
                    ],
                ],
//                'excluded_fields' => ['description']
            ])
            ->add('categories', CollectionType::class, [
                'entry_type' => CategoryType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => [
                    'data-a2lix-formcollection' => null,
                ],
            ])
            ->add('medias', TranslationsFormsType::class, [
                'form_type' => CompanyMediaType::class,
            ])
//            // AutoFormType use without need of declare a dedicated CompanyMediaType
//            ->add('medias', TranslationsFormsType::class, [
//                'form_type' => AutoFormType::class,
//                'form_options' => [
//                    'data_class' => CompanyMediaLocalize::class
//                ]
//            ])
        ;

        // Manage submit label
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            $form = $event->getForm();
            $data = $event->getData();

            if (null === $data) {
                return;
            }

            $form
                ->add('save', SubmitType::class, [
                    'label' => $data->getId() ? 'Edit' : 'Create',
                    'attr' => [
                        'class' => 'btn-primary btn-lg btn-block',
                    ],
                ])
            ;
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
