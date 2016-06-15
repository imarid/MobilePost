<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParcelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parcelHash', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label' => 'Kod paczki'
            ))
            ->add('notes', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class,array(
                'label' => 'Notatki'
            ))
            ->add('weight', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class, array(
                "label" => "Waga"
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Parcel'
        ));
    }
}
