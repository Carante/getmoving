<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('middleName', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'required'=>false,
            ))
            ->add('lastName', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('email', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('phone', 'Symfony\Component\Form\Extension\Core\Type\NumberType')
            ->add('dateOfBirth', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'widget'=>'choice',
                'years' => range(date('Y')-16, date('Y')-80),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'app_bundle_user_type';
    }
}
