<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class ParcelOrderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Wielki formularz, wszystkie dane dodawane np. imie, nazwisko itd.
        // Symfony nie przetworzy takiego duzego jsona, wiec trzeba "wyluskiwac"
        // trzeba tworzyc osobne instacje np. paczka, sandler itd. i dopiero na podstawie tego
        // stworzyc zamowienie //(np. aPPBundle:Parcel (chyba))
        $builder
            ->add('parcel', ParcelType::class, array(
                "data_class" =>  \AppBundle\Entity\Parcel::class,
                "label" => "Paczka"
            ))
            ->add('sender', AddressDataType::class, array(
                "data_class" => \AppBundle\Entity\AddressData::class,
                "label" => "Nadawca"
            ))
            ->add('receiver', AddressDataType::class, array(
                "data_class" => \AppBundle\Entity\AddressData::class,
                "label" => "Odbiorca"
            ))
            ->add('status', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                "label" => "Status",
            ))
            ->add('tracking', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, array(
                "label" => "Śledzenie",
                "choices" => array("Tak"=>true, "Nie"=>false),
                "multiple" => false,
                'expanded' => true,
            ))
            ->add('save', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, array(
                "label" => "Dodaj"
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ParcelOrder',
            'csrf_protection' => false
        ));
    }
}
