<?php
/**
 * Created by PhpStorm.
 * User: carante
 * Date: 26/12/2016
 * Time: 19.02
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 * @ORM\Table(name="document")
 */
class Document
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $file_name;

	/**
	 * @ORM\Column(type="string")
	 */
	private $path;

	/**
	 * @ORM\Column(type="string")
	 */
	private $type;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $dateUploaded;



	public function __construct(){
		$this->dateUploaded = new \DateTime();
	}


	//////////////////////////////////////
	// Get ID for relations and references
	public function getId()
	{
		return $this->id;
	}


	//////////////////////////
	// MEDIA DETAILS GET'n'SET

	// Path (udloads/media-library/yyyy/mm)
	public function getPath()
	{
		return $this->path;
	}
	public function setPath($path)
	{
		$this->path = $path;
	}

	// Type (image, video etc.)
	public function getType()
	{
		return $this->type;
	}
	public function setType($type)
	{
		$this->type = $type;
	}

	// Date uploaded
	public function getDateUploaded()
	{
		return $this->dateUploaded;
	}
	public function setDateUploaded($dateUploaded)
	{
		$this->dateUploaded = $dateUploaded;
	}

	// File name
	public function getFileName()
	{
		return $this->file_name;
	}
	public function setFileName($file_name)
	{
		$this->file_name = $file_name;
	}




//	public function removeMedia(Media $media)
//	{
//		$this->removeMedia($media);
//	}


}