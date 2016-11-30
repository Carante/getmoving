<?php
/**
 * Created by PhpStorm.
 * User: carante
 * Date: 28/11/2016
 * Time: 10.52
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganisationRepository")
 * @ORM\Table(name="organisation")
 */
class Organisation
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
	private $name;

	/**
	 * @ORM\Column(type="string")
	 */
	private $description;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $mission;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $vision;

	/**
	 * @ORM\Column(type="json_array", nullable=true)
	 */
	private $coreValues = [];

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", inversedBy="posts")
	 */
	private $logo;

	/**
	 * @ORM\Column(type="text")
	 */
	private $about;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $punchline;

	/**
	 * @ORM\Column(type="string")
	 */
	private $emailSupport;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $emailOfficial;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $address;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $facebook;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $twitter;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $linkedin;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $youtube;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $snapchat;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $instagram;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $googleplus;

	public function __construct()
	{
		$this->cover = new ArrayCollection();
	}

	/////////////////////
	// IDENTITY GET'n'SET

	// Organisation Name
	public function getName()
	{
		return $this->name;
	}
	public function setName($name)
	{
		$this->name = $name;
	}

	// Logo media
	public function getLogo()
	{
		return $this->logo;
	}

	public function setLogo($logo)
	{
		$this->logo = $logo;
	}

	////////////////////////////////
	// BUSINESS ESSENTIALS GET'n'SET

	// Short description (for meta)
	public function getDescription()
	{
		return $this->description;
	}
	public function setDescription($description)
	{
		$this->description = $description;
	}

 // Mission
	public function getMission()
	{
		return $this->mission;
	}
	public function setMission($mission)
	{
		$this->mission = $mission;
	}

	// Vision
	public function getVision()
	{
		return $this->vision;
	}
	public function setVision($vision)
	{
		$this->vision = $vision;
	}

	// Values
	public function getCoreValues()
	{
		$coreValues[] = $this->coreValues;
		return $coreValues;
	}
	public function setCoreValues($coreValues)
	{
		$this->coreValues = $coreValues;
	}

	// About, Longer description to print on "why"
	public function getAbout()
	{
		return $this->about;
	}
	public function setAbout($about)
	{
		$this->about = $about;
	}

	// Punch line
	public function getPunchline()
	{
		return $this->punchline;
	}
	public function setPunchline($punchline)
	{
		$this->punchline = $punchline;
	}


	////////////////////
	// CONTACT GET'n'SET

	// Support Email
	public function getEmailSupport()
	{
		return $this->emailSupport;
	}
	public function setEmailSupport($emailSupport)
	{
		$this->emailSupport = $emailSupport;
	}

	// Official Email
	public function getEmailOfficial()
	{
		return $this->emailOfficial;
	}
	public function setEmailOfficial($emailOfficial)
	{
		$this->emailOfficial = $emailOfficial;
	}

	// Address
	public function getAddress()
	{
		return $this->address;
	}
	public function setAddress($address)
	{
		$this->address = $address;
	}


	/////////////////////////
	// SOCIAL MEDIA GET'n'SET

	// Facebook
	public function getFacebook()
	{
		return $this->facebook;
	}
	public function setFacebook($facebook)
	{
		$this->facebook = $facebook;
	}

	//Twitter
	public function getTwitter()
	{
		return $this->twitter;
	}
	public function setTwitter($twitter)
	{
		$this->twitter = $twitter;
	}

	// LinkedIn
	public function getLinkedin()
	{
		return $this->linkedin;
	}
	public function setLinkedin($linkedin)
	{
		$this->linkedin = $linkedin;
	}

	// Youtube
	public function getYoutube()
	{
		return $this->youtube;
	}
	public function setYoutube($youtube)
	{
		$this->youtube = $youtube;
	}

	// Snapchat
	public function getSnapchat()
	{
		return $this->snapchat;
	}
	public function setSnapchat($snapchat)
	{
		$this->snapchat = $snapchat;
	}

	// Instagram
	public function getInstagram()
	{
		return $this->instagram;
	}
	public function setInstagram($instagram)
	{
		$this->instagram = $instagram;
	}

	// GooglePlus
	public function getGoogleplus()
	{
		return $this->googleplus;
	}
	public function setGoogleplus($googleplus)
	{
		$this->googleplus = $googleplus;
	}


}


?>