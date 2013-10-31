<?php

namespace A2lix\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('DELETE')
            ->add('delete', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'btn btn-danger'
                )
            ))
        ;
    }

    public function getName()
    {
        return 'delete';
    }
}