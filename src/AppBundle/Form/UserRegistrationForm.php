<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProgramParticipants;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$countryChoices = $this->arrayOfCountries("country");
		$nationalityChoices = $this->arrayOfCountries("nationality");

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
				'choices' => $nationalityChoices
			))
			->add('plainPassword', RepeatedType::class, array(
				'type' => PasswordType::class
			))
			->add('addressCountry', ChoiceType::class, array(
				'choices' => $countryChoices
			))
			->add('addressStreet', TextType::class)
			->add('addressPoBox', TextType::class, array(
				'required' => false,
			))
			->add('addressHouseNo', TextType::class)
			->add('addressCo', TextType::class, array(
				'required' => false,
			))
			->add('addressZip', TextType::class)
			->add('addressCity', TextType::class)
			->add('addressRegion', TextType::class)
			->add('eduCurrentPlace', TextType::class)
			->add('eduCurrentProgram', TextType::class)
			->add('eduFuturePlace', TextType::class, array(
				'required' => false,
			))
			->add('eduFutureProgram', TextType::class, array(
				'required' => false,
			))
			->add('eduLevelExpected', TextType::class)
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => User::class,
			'validation_groups' => ['Default', 'Registration']
		));
	}


	private function arrayOfCountries($data)
	{
		$countries = json_decode(file_get_contents('../web/dist/countries.json'), true);
		if ($data == "nationality")
		{
			$countryChoices = array();
			foreach ($countries as $country) {
				$countryChoices[$country['name']['common']] = $country['demonym'];
			}
		}
		if ($data == "country")
		{
			$countryChoices = array();
			foreach ($countries as $country) {
				$countryChoices[$country['name']['common']] = $country['name']['common'];
			}
		}


		return $countryChoices;
	}
}
