<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$countryChoices = $this->arrayOfCountries();

		$builder->add('firstName', TextType::class)
			->add('middleName', TextType::class, array(
				'required' => false,
			))
			->add('lastName', TextType::class)
			->add('sex', ChoiceType::class, array(
				'choices' => array(
					'Male' => 1,
					'Female' => 2
				),
				'expanded' => true
			))
			->add('dateOfBirth', BirthdayType::class, array())
			->add('email', EmailType::class)
			->add('phone', NumberType::class)
			->add('nationality', ChoiceType::class, array(
				'choices' => $countryChoices
			))
			->add('plainPassword', RepeatedType::class, array(
				'type' => PasswordType::class
			));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => User::class,
		));
	}

	public function getName()
	{
		return 'admin_type';
	}

	private function arrayOfCountries()
	{
		$countries = json_decode(file_get_contents('../web/dist/countries.json'), true);
		$countryChoices = array();
		foreach ($countries as $country) {
			$countryChoices[$country['name']['common']] = $country['cca3'];
		}

		return $countryChoices;
	}

}
