<?php
/**
 * Created by PhpStorm.
 * User: KaiserDesign
 * Date: 15/11/2016
 * Time: 00:35
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=70)
	 */
	private $firstName;

	/**
	 * @ORM\Column(type="string", nullable=true, length=70)
	 */
	private $middleName;

	/**
	 * @ORM\Column(type="string", length=70)
	 */
	private $lastName;

	/**
	 * @ORM\Column(type="date")
	 */
	private $dateOfBirth;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $sex;

	/**
	 * @ORM\Column(type="string", length=3)
	 */
	private $nationality;

	/**
	 * @ORM\Column(type="string")
	 */
	private $passportNo;

	/**
	 * @ORM\Column(type="string")
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $phone;

	// Address fields starts
	/**
	 * @ORM\Column(type="string", length=84)
	 */
	private $addressCountry;

	/**
	 * @ORM\Column(type="string")
	 */
	private $addressOne;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $addressTwo;

	/**
	 * @ORM\Column(type="string")
	 */
	private $addressHouseNo;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $addressFlat;

	/**
	 * @ORM\Column(type="string")
	 */
	private $addressZip;

	/**
	 * @ORM\Column(type="string")
	 */
	private $addressCity;

	/**
	 * @ORM\Column(type="string")
	 */
	private $addressRegion;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $addressCo;
	// Address fields done

	// Educational fields starts
	/**
	 * @ORM\Column(type="string")
	 */
	private $eduLevelExpected;

	/**
	 * @ORM\Column(type="string")
	 */
	private $eduPlaceCurrent;

	/**
	 * @ORM\Column(type="string")
	 */
	private $eduProgramCurrent;

	/**
	 * @ORM\Column(type="string")
	 */
	private $eduPlaceFuture;

	/**
	 * @ORM\Column(type="string")
	 */
	private $eduProgramFuture;
	// Educational fields done

	/**
	 * @ORM\Column(type="string")
	 */
	private $password;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isNotified = true;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isActive = true;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $passportFile;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $planeoutFile;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $policereportFile;






	public function getId()
	{
		return $this->id;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}

	public function getMiddleName()
	{
		return $this->middleName;
	}

	public function setMiddleName($middleName)
	{
		$this->middleName = $middleName;
	}

	public function getLastName()
	{
		return $this->lastName;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}

	public function getDateOfBirth()
	{
		return $this->dateOfBirth;
	}

	public function setDateOfBirth($dateOfBirth)
	{
		$this->dateOfBirth = $dateOfBirth;
	}

	public function getSex()
	{
		return $this->sex;
	}

	public function setSex($sex)
	{
		$this->sex = $sex;
	}

	public function getNationality()
	{
		return $this->nationality;
	}

	public function setNationality($nationality)
	{
		$this->nationality = $nationality;
	}

	public function getPassportNo()
	{
		return $this->passportNo;
	}

	public function setPassportNo($passportNo)
	{
		$this->passportNo = $passportNo;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

	public function getAddressCountry()
	{
		return $this->addressCountry;
	}

	public function setAddressCountry($addressCountry)
	{
		$this->addressCountry = $addressCountry;
	}

	public function getAddressOne()
	{
		return $this->addressOne;
	}

	public function setAddressOne($addressOne)
	{
		$this->addressOne = $addressOne;
	}

	public function getAddressTwo()
	{
		return $this->addressTwo;
	}

	public function setAddressTwo($addressTwo)
	{
		$this->addressTwo = $addressTwo;
	}

	public function getAddressHouseNo()
	{
		return $this->addressHouseNo;
	}

	public function setAddressHouseNo($addressHouseNo)
	{
		$this->addressHouseNo = $addressHouseNo;
	}

	public function getAddressFlat()
	{
		return $this->addressFlat;
	}

	public function setAddressFlat($addressFlat)
	{
		$this->addressFlat = $addressFlat;
	}

	public function getAddressZip()
	{
		return $this->addressZip;
	}

	public function setAddressZip($addressZip)
	{
		$this->addressZip = $addressZip;
	}

	public function getAddressCity()
	{
		return $this->addressCity;
	}

	public function setAddressCity($addressCity)
	{
		$this->addressCity = $addressCity;
	}

	public function getAddressRegion()
	{
		return $this->addressRegion;
	}

	public function setAddressRegion($addressRegion)
	{
		$this->addressRegion = $addressRegion;
	}

	public function getAddressCo()
	{
		return $this->addressCo;
	}

	public function setAddressCo($addressCo)
	{
		$this->addressCo = $addressCo;
	}

	public function getEduLevelExpected()
	{
		return $this->eduLevelExpected;
	}

	public function setEduLevelExpected($eduLevelExpected)
	{
		$this->eduLevelExpected = $eduLevelExpected;
	}

	public function getEduPlaceCurrent()
	{
		return $this->eduPlaceCurrent;
	}

	public function setEduPlaceCurrent($eduPlaceCurrent)
	{
		$this->eduPlaceCurrent = $eduPlaceCurrent;
	}

	public function getEduProgramCurrent()
	{
		return $this->eduProgramCurrent;
	}

	public function setEduProgramCurrent($eduProgramCurrent)
	{
		$this->eduProgramCurrent = $eduProgramCurrent;
	}

	public function getEduPlaceFuture()
	{
		return $this->eduPlaceFuture;
	}

	public function setEduPlaceFuture($eduPlaceFuture)
	{
		$this->eduPlaceFuture = $eduPlaceFuture;
	}

	public function getEduProgramFuture()
	{
		return $this->eduProgramFuture;
	}

	public function setEduProgramFuture($eduProgramFuture)
	{
		$this->eduProgramFuture = $eduProgramFuture;
	}

	public function getIsNotified()
	{
		return $this->isNotified;
	}

	public function setIsNotified($isNotified)
	{
		$this->isNotified = $isNotified;
	}

	public function getIsActive()
	{
		return $this->isActive;
	}

	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
	}

	public function getPassportFile()
	{
		return $this->passportFile;
	}

	public function setPassportFile($passportFile)
	{
		$this->passportFile = $passportFile;
	}

	public function getPlaneoutFile()
	{
		return $this->planeoutFile;
	}

	public function setPlaneoutFile($planeoutFile)
	{
		$this->planeoutFile = $planeoutFile;
	}

	public function getPolicereportFile()
	{
		return $this->policereportFile;
	}

	public function setPolicereportFile($policereportFile)
	{
		$this->policereportFile = $policereportFile;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}


}