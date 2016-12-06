<?php
/**
 * Created by PhpStorm.
 * User: carante
 * Date: 29/11/2016
 * Time: 09.22
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgramRepository")
 * @ORM\Table(name="program")
 */
class Program
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
	private $title;

	/**
	 * @ORM\Column(type="string")
	 */
	private $teaser;

	/**
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @ORM\Column(type="string")
	 */
	private $role;

	/**
	 * @ORM\Column(type="string")
	 */
	private $location;

	/**
	 * @ORM\Column(type="string")
	 */
	private $stay;

	/**
	 * @ORM\Column(type="string")
	 */
	private $meals;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $minDuration;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $price;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	private $startDate;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $flexStart;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isActive = true;

	/**
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
	 * @ORM\JoinTable(name="program_participants")
	 */
	private $programParticipant;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media")
	 */
	private $feature;

	/**
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Media")
	 * @ORM\JoinTable(name="program_media")
	 */
	private $programMedia;


	public function __construct()
	{
		$this->programParticipant = new ArrayCollection();
		$this->programMedia = new ArrayCollection();
	}


	///////////////////////
	// GET ID FOR LINKS ao.
	public function getId()
	{
		return $this->id;
	}


	/////////////////////////
	// GENERAL INFO GET'n'SET

	// Title
	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	// Teaser (short intro, usage for google as well)
	public function getTeaser()
	{
		return $this->teaser;
	}

	public function setTeaser($teaser)
	{
		$this->teaser = $teaser;
	}

	// Description long.
	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}


	////////////////////////
	// BULLET INFO GET'n'SET

	// Role
	public function getRole()
	{
		return $this->role;
	}

	public function setRole($role)
	{
		$this->role = $role;
	}

	// Location (City, Region, Country)
	public function getLocation()
	{
		return $this->location;
	}

	public function setLocation($location)
	{
		$this->location = $location;
	}

	// Stay (Hostel, family, fin yourself etc.
	public function getStay()
	{
		return $this->stay;
	}

	public function setStay($stay)
	{
		$this->stay = $stay;
	}

	// Meals (included in price)
	public function getMeals()
	{
		return $this->meals;
	}

	public function setMeals($meals)
	{
		$this->meals = $meals;
	}

	// Minimum duration of stay (weeks)
	public function getMinDuration()
	{
		return $this->minDuration;
	}

	public function setMinDuration($minDuration)
	{
		$this->minDuration = $minDuration;
	}

	// Price pr. week
	public function getPrice()
	{
		return $this->price;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}


	///////////////////////
	// START DATE GET'n'SET

	// Startdate
	public function getStartDate()
	{
		return $this->startDate;
	}

	public function setStartDate($startDate)
	{
		$this->startDate = $startDate;
	}

	// Flexible
	public function getFlexStart()
	{
		return $this->flexStart;
	}

	public function setFlexStart($flexStart)
	{
		$this->flexStart = $flexStart;
	}


	//////////////////////////
	// ACCESSIBILITY GET'n'SET

	// Is active
	public function getIsActive()
	{
		return $this->isActive;
	}

	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
	}


	/////////////////////
	// RELATION FUNCTIONS

	// Feature media get'n'set
	public function getFeature()
	{
		return $this->feature;
	}

	public function setFeature(Media $feature)
	{
		$this->feature = $feature;
	}

	public function getProgramParticipant()
	{
		return $this->programParticipant;
	}
	public function addProgramParticipant(User $user)
	{
		if ($this->programParticipant->contains($user)) {
			return;
		}
		$this->programParticipant[] = $user;
	}

	public function getProgramMedia()
	{
		return $this->programMedia;
	}
	public function addProgramMedia(Media $media)
	{
		if ($this->programMedia->contains($media)) {
			return;
		}
		$this->programMedia[] = $media;
	}
	public function removeProgramMedia(Media $media)
	{
		$this->programMedia->removeElement($media);
	}


}


// Billeder
