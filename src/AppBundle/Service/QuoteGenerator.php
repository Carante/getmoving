<?php
/**
 * Created by PhpStorm.
 * User: KaiserDesign
 * Date: 15/11/2016
 * Time: 02:11
 */

namespace AppBundle\Service;


use Psr\Log\LoggerInterface;

class QuoteGenerator
{

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	public function __construct(LoggerInterface $logger)
	{

		$this->logger = $logger;
	}

	public function getRandomName()
	{
		$names = array(
			'Simona',
			'Stine',
			'Katrine',
			'Masiell',
			'Maureen',
			'Madi',
			'Emilie',
			'Therese',
			'Josefine',
			'Thit',
			'Nadine',
		);

		$key = array_rand($names);
		$name = $names[$key];
		$this->logger->info("Select a Name: ".$name);

		return $name;
	}
}