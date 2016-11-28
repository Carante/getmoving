<?php

namespace AppBundle\Form;

use AppBundle\Entity\Identity;
use Faker\Provider\ar_JO\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdentityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
			$builder
				->add('logo', TextType::class, array())
				->add('mainColor', TextType::class, array())
				->add('secondColor', TextType::class, array())
			;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
			$resolver->setDefaults(array(
				'data_class' => Identity::class
			));
    }

    public function getName()
    {
        return 'identity_type';
    }
}
