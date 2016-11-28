<?php
/**
 * Created by PhpStorm.
 * User: carante
 * Date: 27/11/2016
 * Time: 23.55
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IdentityRepository")
 * @ORM\Table(name="identity")
 */
class Identity
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
 private $logo;

 /**
	* @ORM\Column(type="string")
	*/
 private $mainColor;

 /**
	* @ORM\Column(type="string")
	*/
 private $secondColor;


	public function setId($id)
	{
		$this->id = $id;
	}

	public function getLogo()
	{
		return $this->logo;
	}
	public function setLogo($logo)
	{
		$this->logo = $logo;
	}

	public function getMainColor()
	{
		return $this->mainColor;
	}
	public function setMainColor($mainColor)
	{
		$this->mainColor = $mainColor;
	}

	public function getSecondColor()
	{
		return $this->secondColor;
	}
	public function setSecondColor($secondColor)
	{
		$this->secondColor = $secondColor;
	}

}