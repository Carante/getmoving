<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
			$attr = [
				'class' => 'file',
				'data-show-caption' => 'false',
				'accept' => "image/*",
				"multiple" => "true"
			];
//			$route != "medialibrary" ? $attr['data-show-upload'] = 'false' : $attr['data-show-upload'] = 'true' ;

			$builder
				->add('path', FileType::class, array(
					'attr' => $attr,
					'label_attr' => array(
						'style' => 'display:none',
					)
				))
			;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
			$resolver->setDefaults(array(
				'data_class' => 'AppBundle\Entity\Media'
			));
    }

    public function getName()
    {
        return 'media_type';
    }
}
