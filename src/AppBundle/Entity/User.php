<?php
/**
 * Created by PhpStorm.
 * User: KaiserDesign
 * Date: 17/11/2016
 * Time: 19:35
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"email"}, message="The email address is already in use")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 * @ORM\Column(type="string", unique=true)
	 */
	private $email;

	/**
	 * @ORM\Column(type="string")
	 */
	private $password;

	/**
	 * @ORM\Column(type="json_array")
	 */
	private $roles = [];

	/**
	 * @Assert\NotBlank(groups={"Registration"})
	 */
	private $plainPassword;


	public function getId()
	{
		return $this->id;
	}

	public function getUsername()
	{
		return $this->email;
	}

	public function getRoles()
	{
		$roles = $this->roles;
		if (!in_array('ROLE_USER', $roles)) {
			$roles[] = 'ROLE_USER';
		}

		return $roles;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getSalt()
	{
	}

	public function eraseCredentials()
	{
		$this->plainPassword = null;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}


	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	public function setPlainPassword($plainPassword)
	{
		$this->plainPassword = $plainPassword;
		// Make sure Doctrine thinks the password is changed, and ensure salt
		$this->password = null;
	}

	public function setRoles($roles)
	{
		$this->roles = $roles;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function __construct()
	{
		$this->date = new \DateTime();
	}


	// Busines logic fields
	/**
	 * @ORM\Column(type="string")
	 */
	private $firstName;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $middleName;

	/**
	 * @ORM\Column(type="string")
	 */
	private $lastName;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	private $dateOfBirth;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $sex;

	/**
	 * @ORM\Column(type="string", length=3)
	 */
	private $nationality;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $phone;


	// Address Information
	/**
	 * @ORM\Column(type="string")
	 */
	private $addressCountry;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $addressRegion;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $addressZip;

	/**
	 * @ORM\Column(type="string")
	 */
	private $addressCity;

	/**
	 * @ORM\Column(type="string")
	 */
	private $addressStreet;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $addressPoBox;

	/**
	 * @ORM\Column(type="string")
	 */
	private $addressHouseNo;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $addressCo;


	// Educational Information
	/**
	 * @ORM\Column(type="string")
	 */
	private $eduLevelExpected;

	/**
	 * @ORM\Column(type="string")
	 */
	private $eduCurrentPlace;

	/**
	 * @ORM\Column(type="string")
	 */
	private $eduCurrentProgram;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $eduFuturePlace;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $eduFutureProgram;


	// Program signup fields
	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	private $programArrival;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $programDuration;


	// Selective boolean
	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isNotified = true;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isActive = true;


	// External files needed
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $passportFile;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $planeOutFile;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $policeReportFile;


	///////////////////////
	// PERSONAL INFORMATION

	// First Name getter'n'setter
	public function getFirstName()
	{
		return $this->firstName;
	}

	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}

	// Middle Name getter'n'setter
	public function getMiddleName()
	{
		return $this->middleName;
	}

	public function setMiddleName($middleName)
	{
		$this->middleName = $middleName;
	}

	// Last Name getter'n'setter
	public function getLastName()
	{
		return $this->lastName;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}

	// Date of birth getter'n'setter
	public function getDateOfBirth()
	{
		return $this->dateOfBirth;
	}

	public function setDateOfBirth($dateOfBirth)
	{
		$this->dateOfBirth = $dateOfBirth;
	}

	// Gender getter'n'setter
	public function getSex()
	{
		return $this->sex;
	}

	public function setSex($sex)
	{
		$this->sex = $sex;
	}

	// Nationality getter'n'setter
	public function getNationality()
	{
		return $this->nationality;
	}

	public function setNationality($nationality)
	{
		$this->nationality = $nationality;
	}


	// Phone number getter'n'setter
	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;
	}


	//////////////////////
	// ADDRESS INFORMATION

	// Country getter'n'setter
	public function getAddressCountry()
	{
		return $this->addressCountry;
	}

	public function setAddressCountry($addressCountry)
	{
		$this->addressCountry = $addressCountry;
	}

	// Region getter'n'setter
	public function getAddressRegion()
	{
		return $this->addressRegion;
	}

	public function setAddressRegion($addressRegion)
	{
		$this->addressRegion = $addressRegion;
	}

	// Zip code getter'n'setter
	public function getAddressZip()
	{
		return $this->addressZip;
	}

	public function setAddressZip($addressZip)
	{
		$this->addressZip = $addressZip;
	}

	// City getter'n'setter
	public function getAddressCity()
	{
		return $this->addressCity;
	}

	public function setAddressCity($addressCity)
	{
		$this->addressCity = $addressCity;
	}

	// Streetname getter'n'setter
	public function getAddressStreet()
	{
		return $this->addressStreet;
	}

	public function setAddressStreet($addressStreet)
	{
		$this->addressStreet = $addressStreet;
	}

	// PoBox getter'n'setter
	public function getAddressPoBox()
	{
		return $this->addressPoBox;
	}

	public function setAddressPoBox($addressPoBox)
	{
		$this->addressPoBox = $addressPoBox;
	}

	// House Number getter'n'setter
	public function getAddressHouseNo()
	{
		return $this->addressHouseNo;
	}

	public function setAddressHouseNo($addressHouseNo)
	{
		$this->addressHouseNo = $addressHouseNo;
	}

	// CO name getter'n'setter
	public function getAddressCo()
	{
		return $this->addressCo;
	}

	public function setAddressCo($addressCo)
	{
		$this->addressCo = $addressCo;
	}


	///////////////////////
	// EDUCATION INFORMATION

	// Expected Lebel getter'n'setter
	public function getEduLevelExpected()
	{
		return $this->eduLevelExpected;
	}

	public function setEduLevelExpected($eduLevelExpected)
	{
		$this->eduLevelExpected = $eduLevelExpected;
	}

	// Current university getter'n'setter
	public function getEduCurrentPlace()
	{
		return $this->eduCurrentPlace;
	}

	public function setEduCurrentPlace($eduCurrentPlace)
	{
		$this->eduCurrentPlace = $eduCurrentPlace;
	}

	// Current studies getter'n'setter
	public function getEduCurrentProgram()
	{
		return $this->eduCurrentProgram;
	}

	public function setEduCurrentProgram($eduCurrentProgram)
	{
		$this->eduCurrentProgram = $eduCurrentProgram;
	}

	// Future university getter'n'setter
	public function getEduFuturePlace()
	{
		return $this->eduFuturePlace;
	}

	public function setEduFuturePlace($eduFuturePlace)
	{
		$this->eduFuturePlace = $eduFuturePlace;
	}

	// Future studies getter'n'setter
	public function getEduFutureProgram()
	{
		return $this->eduFutureProgram;
	}

	public function setEduFutureProgram($eduFutureProgram)
	{
		$this->eduFutureProgram = $eduFutureProgram;
	}


	//////////////////////
	// Program information

	// Arrival getter'n'setter
	public function getProgramArrival()
	{
		return $this->programArrival;
	}

	public function setProgramArrival($programArrival)
	{
		$this->programArrival = $programArrival;
	}

	// Duration getter'n'setter
	public function getProgramDuration()
	{
		return $this->programDuration;
	}

	public function setProgramDuration($programDuration)
	{
		$this->programDuration = $programDuration;
	}


	//////////////////
	// BOOLEAN CHOICES

	// Is Notified getter'n'setter
	public function getIsNotified()
	{
		return $this->isNotified;
	}

	public function setIsNotified($isNotified)
	{
		$this->isNotified = $isNotified;
	}

	// Is Active getter'n'setter
	public function getIsActive()
	{
		return $this->isActive;
	}

	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
	}


	////////////////////////////
	// External files and proves

	// Passoport copy getter'n'setter
	public function getPassportFile()
	{
		return $this->passportFile;
	}

	public function setPassportFile($passportFile)
	{
		$this->passportFile = $passportFile;
	}

	// Ticket out of country getter'n'setter
	public function getPlaneOutFile()
	{
		return $this->planeOutFile;
	}

	public function setPlaneOutFile($planeOutFile)
	{
		$this->planeOutFile = $planeOutFile;
	}

	// PoliceReport copy getter'n'setter
	public function getPoliceReportFile()
	{
		return $this->policeReportFile;
	}

	public function setPoliceReportFile($policeReportFile)
	{
		$this->policeReportFile = $policeReportFile;
	}


}