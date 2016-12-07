<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 * @ORM\Table(name="media")
 */
class Media
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
	 * @ORM\Column(type="integer")
	 */
	private $size;

	/**
	 * @ORM\Column(type="string")
	 */
	private $format;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $dateUploaded;


	public function __construct(){
		$this->dateUploaded = new \DateTime();
//		$this->organistation = new ArrayCollection();
	}

	/**
	 * ORM\OneToMany(targetEntity="Organisation", mappedBy="media")
	 */
//	private $organisation ;


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

	// File size
	public function getSize()
	{
		return $this->size;
	}
	public function setSize($size)
	{
		$this->size = $size;
	}

	// Format (image, video etc.)
	public function getFormat()
	{
		return $this->format;
	}
	public function setFormat($format)
	{
		$this->format = $format;
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


	public function removeMedia(Media $media)
	{
		$this->removeMedia($media);
	}


	/////////////////////////////////
	// Get Organisation for relations
//	public function getOrganisation()
//	{
//		return $this->organisation;
//	}


}