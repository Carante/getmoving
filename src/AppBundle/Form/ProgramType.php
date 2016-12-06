<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Controller\BaseController as Controller;

class ProgramType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title', TextType::class)
			->add('teaser', TextType::class)
			->add('role', TextType::class)
			->add('location', TextType::class)
			->add('stay', TextType::class)
			->add('meals', ChoiceType::class, array(
				'choices' => array(
					'None' => 'None',
					'Breakfast' => 'Breakfast',
					'Dinner' => 'Dinner',
					'Breakfast + Dinner' => 'Breakfast + Dinner',
					'All meals' => 'All meals',
					'Unknown' => 'Unknown'
				)
			))
			->add('price', IntegerType::class, array(
				'label' => 'Price/week (FJD)'
			))
			->add('minDuration', IntegerType::class, array(
				'label' => 'Minimum Duraion (weeks)'
			))
			->add('startDate', DateType::class, array(
				'placeholder' => array(
					'year' => 'Year', 'month' => 'Month', 'day' => 'Day'
				),
				'format' => 'yyyy MMM dd',
				'required' => false
			))
			->add('flexStart', CheckboxType::class, array(
				'required' => false,
				'label' => 'Flexible'
			))
			->add('description', TextareaType::class, array())
			->add('isActive', CheckboxType::class, array(
				'required' => false,
				'label' => 'Active'
			))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Program'
		));
	}

	public function getName()
	{
		return 'program_type';
	}

}
