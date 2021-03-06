<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetrievePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
			$builder->add('email', EmailType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
			$resolver->setDefaults(array(
				'data_class' => null
			));
    }

    public function getName()
    {
        return 'reset_password_type';
    }
}
