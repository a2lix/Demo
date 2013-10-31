<?php

namespace A2lix\DemoTranslationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProductGedmoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', 'a2lix_translations_gedmo', array(
                'required' => false
            ))
        ;
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            if (null === $data) {
                return;
            }

            $form
                ->add('save', 'submit', array(
                    'label' => $data->getId() ? 'Edit' : 'Create',
                    'attr' => array(
                        'class' => 'btn btn-primary'
                    )
                ))
             ;
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'A2lix\DemoTranslationBundle\Entity\ProductGedmo',
        ));
    }

    public function getName()
    {
        return 'productGedmo';
    }
}
