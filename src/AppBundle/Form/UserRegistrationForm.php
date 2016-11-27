<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
		$countryChoices = $this->arrayOfCountries();
		$durationChoices = $this->arrayOfDuration();

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
			->add('dateOfBirth', BirthdayType::class, array())
			->add('email', EmailType::class)
			->add('phone', NumberType::class)
			->add('nationality', ChoiceType::class, array(
				'choices' => $countryChoices
			))
			->add('plainPassword', RepeatedType::class, array(
				'type' => PasswordType::class
			))
			->add('programArrival', \Symfony\Component\Form\Extension\Core\Type\DateType::class, array(
				// add a class that can be selected in JavaScript
//				'attr' => ['class' => 'datepicker']
			))
			->add('programDuration', ChoiceType::class, array(
				'choices' => $durationChoices
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


	private function arrayOfCountries()
	{
		$countries = json_decode(file_get_contents('../web/dist/countries.json'), true);
		$countryChoices = array();
		foreach ($countries as $country) {
			$countryChoices[$country['name']['common']] = $country['cca3'];
		}

		return $countryChoices;
	}

	private function arrayOfDuration()
	{
		$durationChoices = array();
		for ($i = 2; $i <= 12; $i++) {
			$durationChoices[$i." weeks"] = $i;
		}
		return $durationChoices;
	}
}
