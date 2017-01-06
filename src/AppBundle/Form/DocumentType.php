<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProgramParticipants;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
			$attr = [
				'class' => 'file',
				'data-show-caption' => 'false',
				'accept' => "application/pdf",
				"multiple" => "false",
			];

			$builder
				->add('passport', FileType::class, array(
					'attr' => $attr,
					'label' => 'Passport',
					'data_class' => User::class,
					'required' => false,
					'mapped' => false
				))
				->add('criminalRecord', FileType::class, array(
					'attr' => $attr,
					'label' => 'Criminal record',
					'data_class' => User::class,
					'required' => false,
					'mapped' => false
				))
				->add('ticket', FileType::class, array(
					'attr' => $attr,
					'label' => 'Departure ticket',
					'data_class' => ProgramParticipants::class,
					'required' => false,
					'mapped' => false
				))
			;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
			$resolver->setDefaults(array(
				'data_class' =>'AppBundle\Entity\Document'
			));
    }

    public function getName()
    {
        return 'document_type';
    }
}
