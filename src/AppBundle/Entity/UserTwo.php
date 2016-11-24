<?php
/**
 * Created by PhpStorm.
 * User: KaiserDesign
 * Date: 17/11/2016
 * Time: 19:35
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_two")
 */
class UserTwo implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", unique=true)
	 */
	private $email;

	public function getUsername()
	{
		return $this->email;
	}

	public function getRoles()
	{
		return ["ROLE_USER"];
	}

	public function getPassword()
	{
	}

	public function getSalt()
	{
	}

	public function eraseCredentials()
	{
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}



}