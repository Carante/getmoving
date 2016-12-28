<?php

namespace AppBundle\Form;

use AppBundle\Entity\Organisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganisationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$iconsChoices = $this->arrayOfIcons();

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
			->add('coreValueOne', TextType::class, array(
				'required' => false,
				'label' => "Text"
			))
			->add('coreValueOneIcon', ChoiceType::class, array(
				'required' => false,
				'label' => "Icon",
				'choices' => $iconsChoices,
				'attr' => array(
					'class' => 'iconSelector',
					'data-target' => '1'
				)
			))
			->add('coreValueTwo', TextType::class, array(
				'required' => false,
				'label' => "Text"
			))
			->add('coreValueTwoIcon', ChoiceType::class, array(
				'required' => false,
				'label' => "Icon",
				'choices' => $iconsChoices,
				'attr' => array(
					'class' => 'iconSelector',
					'data-target' => '2'
				)
			))
			->add('coreValueThree', TextType::class, array(
				'required' => false,
				'label' => "Text"
			))
			->add('coreValueThreeIcon', ChoiceType::class, array(
				'required' => false,
				'label' => "Icon",
				'choices' => $iconsChoices,
				'attr' => array(
					'class' => 'iconSelector',
					'data-target' => '3'
				)
			))
			->add('coreValueFour', TextType::class, array(
				'required' => false,
				'label' => "Text"
			))
			->add('coreValueFourIcon', ChoiceType::class, array(
				'required' => false,
				'label' => "Icon",
				'choices' => $iconsChoices,
				'attr' => array(
					'class' => 'iconSelector',
					'data-target' => '4'
				)
			))
			->add('coreValueFive', TextType::class, array(
				'required' => false,
				'label' => "Text"
			))
			->add('coreValueFiveIcon', ChoiceType::class, array(
				'required' => false,
				'label' => "Icon",
				'choices' => $iconsChoices,
				'attr' => array(
					'class' => 'iconSelector',
					'data-target' => '5'
				)
			))
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

	private function arrayOfIcons()
	{
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"\\\\(.+)";\s+}/';
		$subject =  file_get_contents('css/font-awesome.css');
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

		foreach($matches as $match) {
			$iconName = explode("-", $match[1]);
			array_splice($iconName, 0, 1);
			$iconName = implode(" ", $iconName);
			$icons[$iconName] = $match[1];
		}

		ksort($icons);

		return $icons;
	}
}
