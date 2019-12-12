<?php

declare(strict_types=1);

namespace App\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslatedEntityType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('translations', TranslationsType::class)
            ->add('category', TranslatedEntityType::class, [
                'class' => Category::class,
                'translation_property' => 'title',
                // Optionnal custom query_builder override. Here, to ordering by title ASC
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->select('e, t')
                        ->join('e.translations', 't')
                        ->orderBy('t.title', 'ASC')
                    ;
                },
            ])
            ->add('media', ProductMediaType::class)
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
            'data_class' => Product::class,
        ]);
    }
}
