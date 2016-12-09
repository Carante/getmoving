<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="program_participants")
 */
class ProgramParticipants
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userPrograms")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $user;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Program", inversedBy="programParticipant")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private	$program;

	/**
	 * @ORM\Column(type="date")
	 */
	private $arrivalDate;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $duration;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isPaid = false;




	public function getId()
	{
		return $this->id;
	}



	public function getUser()
	{
		return $this->user;
	}
	public function setUser($user)
	{
		$this->user = $user;
	}




	public function getProgram()
	{
		return $this->program;
	}
	public function setProgram($program)
	{
		$this->program = $program;
	}




	public function getArrivalDate()
	{
		return $this->arrivalDate;
	}
	public function setArrivalDate($arrivalDate)
	{
		$this->arrivalDate = $arrivalDate;
	}




	public function getDuration()
	{
		return $this->duration;
	}
	public function setDuration($duration)
	{
		$this->duration = $duration;
	}




	public function getIsPaid()
	{
		return $this->isPaid;
	}
	public function setIsPaid($isPaid)
	{
		$this->isPaid = $isPaid;
	}


}