<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/programs")
 */
class ProgramController extends Controller
{
	/**
	 * @Route("/", name="programs_list")
	 */
	public function indexAction()
	{
		return $this->render('/programs/all.html.twig', array(
			'pageTitle' => "GetMoving - programs"
		));
	}
}
