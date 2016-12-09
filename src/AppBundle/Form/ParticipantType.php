<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProgramParticipants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$durationChoices = $this->arrayOfDuration();

		$builder
			->add('arrivalDate', DateType::class)
			->add('duration', ChoiceType::class, array(
				'choices' => $durationChoices
			))
			;
    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver
			->setDefaults(array(
				'data_class' => ProgramParticipants::class
			));
    }

	public function getName()
	{
		return 'participant_type';
	}

	private function arrayOfDuration()
	{
		$durationChoices = array();
		for ($i = 2; $i <= 12; $i++) {
			$durationChoices[$i . " weeks"] = $i;
		}
		return $durationChoices;
	}
}
