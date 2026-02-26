<?php declare(strict_types=1);

namespace App\Form;

use A2lix\AutoFormBundle\Form\Type\AutoType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Product;
use App\Entity\ProductMedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = null !== $options['data']?->id;

        $builder
            ->add('code')
            ->add('translations', TranslationsType::class, [
                'translatable_class' => $options['data_class'],
                // 'children_excluded' => ['description'],
            ])
            // ->add('category', TranslatedEntityType::class, [
            //     'class' => Category::class,
            //     'translation_property' => 'title',
            //     // Optionnal custom query_builder override. Here, to ordering by title ASC
            //     'query_builder' => static fn(EntityRepository $er) => $er->createQueryBuilder('e')
            //         ->select('e, t')
            //         ->join('e.translations', 't')
            //         ->orderBy('t.title', 'ASC'),
            // ])
            ->add('media', AutoType::class, [
                'data_class' => ProductMedia::class,
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
            'data_class' => Product::class,
            // 'attr' => ['novalidate' => ''],
        ]);
    }
}
