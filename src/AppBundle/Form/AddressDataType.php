<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressDataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label'=>'Imię'
            ))
            ->add('lastName', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label'=>'Nazwisko',
            ))
            ->add('street', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label'=>'Ulica'
            ))
            ->add('postalCode', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label' => 'Kod pocztowy'
            ))
            ->add('phone', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'label'=>'Nr tel.'
            ))
            ->add('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class, array(
                'label' => 'E-mail'
            ))
            ->add('city', CityType::class, array(
                "data_class" => \AppBundle\Entity\City::class,
                "label" => "Miasto"
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AddressData'
        ));
    }
}
