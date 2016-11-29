<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Identity;
use AppBundle\Entity\Organisation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseController extends Controller
{
	/**
	 * @return \Doctrine\Common\Persistence\ObjectManager|object
	 */
	protected function getEntityManager()
	{
		$em = $this->getDoctrine()->getManager();

		return $em;
	}

	protected function viewVariables($pageName)
	{
		$viewVar['pageTitle'] = $pageName . "|GetMoving";

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();

		$identities = $this->getDoctrine()->getRepository('AppBundle:Identity')->findAll();
		if (!empty($identities)) {
			$count = count($identities) - 1;
			$currentIdentity = $identities[$count];
		} else {
			$currentIdentity = new Identity();
		}
		$viewVar['identity'] = $currentIdentity;

		$volunteers = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
		$viewVar['volunteers'] = $volunteers;

		$programs = $this->getDoctrine()->getRepository('AppBundle:Program')->findAll();
		$viewVar['programs'] = $programs;

		$orgName = "Dummy";
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];

			$orgName = $currentOrg->getName();
		} else {
			$currentOrg = new Organisation();
		}
		$viewVar['organisation'] = $currentOrg;
		$viewVar['orgName'] = $orgName;

		return $viewVar;
	}

	protected function viewVariablesPublic($pageName)
	{
		$viewVar['pageTitle'] = "GetMoving - ".$pageName;

		$programs = $this->getDoctrine()->getRepository('AppBundle:Program')->findAll();
		$viewVar['programs'] = $programs;


		return $viewVar;
	}
}
