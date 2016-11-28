<?php

namespace AppBundle\Form;

use AppBundle\Entity\Organisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganisationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class)
			->add('description', TextType::class)
			->add('punchline', TextType::class, array(
				'required' => false
			))
			->add('about', TextareaType::class)
			->add('mission', TextType::class, array(
				'required' => false
			))
			->add('vision', TextType::class, array(
				'required' => false
			))
			->add('coreValues', CollectionType::class, array(
					'allow_add' => true,
					'prototype' => true,
					'allow_delete' => true,
					'entry_type' => TextType::class,
					'entry_options' => array(
						'label' => false
					)
				)
			)
			->add('emailOfficial', EmailType::class)
			->add('emailSupport', EmailType::class, array(
				'required' => false
			))
			->add('address', TextareaType::class, array(
				'required' => false
			))
			->add('facebook', TextType::class, array(
				'required' => false
			))
			->add('twitter', TextType::class, array(
				'required' => false
			))
			->add('instagram', TextType::class, array(
				'required' => false
			))
			->add('snapchat', TextType::class, array(
				'required' => false
			))
			->add('youtube', TextType::class, array(
				'required' => false
			))
			->add('googleplus', TextType::class, array(
				'required' => false
			))
			->add('linkedin', TextType::class, array(
				'required' => false
			));

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Organisation::class
		));
	}

	public function getName()
	{
		return 'organisation_type';
	}
}
