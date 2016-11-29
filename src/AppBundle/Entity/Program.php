<?php
/**
 * Created by PhpStorm.
 * User: carante
 * Date: 29/11/2016
 * Time: 09.22
 */

namespace AppBundle\Entity;


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



	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}
	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTeaser()
	{
		return $this->teaser;
	}
	public function setTeaser($teaser)
	{
		$this->teaser = $teaser;
	}

	public function getDescription()
	{
		return $this->description;
	}
	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getRole()
	{
		return $this->role;
	}
	public function setRole($role)
	{
		$this->role = $role;
	}

	public function getLocation()
	{
		return $this->location;
	}
	public function setLocation($location)
	{
		$this->location = $location;
	}

	public function getStay()
	{
		return $this->stay;
	}
	public function setStay($stay)
	{
		$this->stay = $stay;
	}

	public function getMeals()
	{
		return $this->meals;
	}
	public function setMeals($meals)
	{
		$this->meals = $meals;
	}

	public function getMinDuration()
	{
		return $this->minDuration;
	}
	public function setMinDuration($minDuration)
	{
		$this->minDuration = $minDuration;
	}

	public function getPrice()
	{
		return $this->price;
	}
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getStartDate()
	{
		return $this->startDate;
	}
	public function setStartDate($startDate)
	{
		$this->startDate = $startDate;
	}

	public function getFlexStart()
	{
		return $this->flexStart;
	}
	public function setFlexStart($flexStart)
	{
		$this->flexStart = $flexStart;
	}




}


// Billeder
