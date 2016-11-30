<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/programs")
 */
class ProgramController extends BaseController
{
	/**
	 * @Route("/", name="programs_list")
	 */
	public function indexAction()
	{
		$viewVar = $this->viewVariablesPublic("Programs");

		return $this->render('/programs/all.html.twig', $viewVar);
	}
}
