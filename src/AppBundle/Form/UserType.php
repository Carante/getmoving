<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
	private function arrayOfCountries() {
		$countries = json_decode(file_get_contents('../web/dist/countries.json'), true);
		$countryChoices = array();
		foreach ($countries as $country) {
			$countryChoices[$country['name']['common']] = $country['cca3'];
		}

		return $countryChoices;
	}
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
				)
			))
			->add('dateOfBirth', BirthdayType::class, array(
			))
			->add('email', TextType::class)
			->add('phone', NumberType::class)
			->add('nationality', ChoiceType::class, array(
				'choices' => $countryChoices
			))
			->add('passportNo', TextType::class)
			->add('password', PasswordType::class)
			->add('addressCountry', ChoiceType::class, array(
				'choices' => $countryChoices
			))
			->add('addressOne', TextType::class)
			->add('addressTwo', TextType::class, array(
				'required' => false,
			))
			->add('addressHouseNo', TextType::class)
			->add('addressFlat', TextType::class, array(
				'required' => false,
			))
			->add('addressCo', TextType::class, array(
				'required' => false,
			))
			->add('addressZip', TextType::class)
			->add('addressCity', TextType::class)
			->add('addressRegion', TextType::class)
			->add('eduPlaceCurrent', TextType::class)
			->add('eduProgramCurrent', TextType::class)
			->add('eduPlaceFuture', TextType::class, array(
				'required' => false,
			))
			->add('eduProgramFuture', TextType::class, array(
				'required' => false,
			))
			->add('eduLevelExpected', TextType::class)
			->add('isNotified', CheckboxType::class, array(
				'required' => false,
			))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			array(
				'data_class' => 'AppBundle\Entity\User',
			)
		);
	}

	public function getName()
	{
		return 'app_bundle_user_type';
	}
}
