<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cover")
 */
class Media
{

	/**
	 * @ORM\Idw
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $title;

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
		$this->dateUploaded = new \DateTime("Pacific/Fiji");
	}

	/**
	 * ORM\OneToMany(targetEntity="Post", mappedBy="cover")
	 */
	private $identities;


	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param mixed $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * @return mixed
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * @param mixed $size
	 */
	public function setSize($size)
	{
		$this->size = $size;
	}

	/**
	 * @return mixed
	 */
	public function getFormat()
	{
		return $this->format;
	}

	/**
	 * @param mixed $format
	 */
	public function setFormat($format)
	{
		$this->format = $format;
	}

	/**
	 * @return \DateTime
	 */
	public function getDateUploaded()
	{
		return $this->dateUploaded;
	}

	/**
	 * @param \DateTime $dateUploaded
	 */
	public function setDateUploaded($dateUploaded)
	{
		$this->dateUploaded = $dateUploaded;
	}

	/**
	 * @return mixed
	 */
	public function getFileName()
	{
		return $this->file_name;
	}

	/**
	 * @param mixed $file_name
	 */
	public function setFileName($file_name)
	{
		$this->file_name = $file_name;
	}

	/**
	 * @return mixed
	 */
	public function getIdentities()
	{
		return $this->identities;
	}


}