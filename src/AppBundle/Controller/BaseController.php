<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Identity;
use AppBundle\Entity\Media;
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


		$profiles = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
		$viewVar['profiles'] = $profiles;
		$profilesCount = count($profiles) - 1;

		$volunteers = [];
		$users = [];
		for ($i = 0 ; $i <= $profilesCount ; ++$i) {
			if (in_array('ROLE_ADMIN', $profiles[$i]->getRoles(), true)){
				$users[] = $profiles[$i];
			} elseif (in_array('ROLE_VOLUNTEER', $profiles[$i]->getRoles(), true)) {
				$volunteers[] = $profiles[$i];
			}
		}
		$viewVar['volunteers'] = $volunteers;
		$viewVar['users'] = $users;

		$programs = $this->getDoctrine()->getRepository('AppBundle:Program')->findAll();
		$viewVar['programs'] = $programs;


		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		$orgName = "Dummy";
		$logo = new Media();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];

			$orgName = $currentOrg->getName();
		} else {
			$currentOrg = new Organisation();
		}
		$viewVar['organisation'] = $currentOrg;
		$viewVar['orgName'] = $orgName;

		$media = $this->getDoctrine()->getRepository('AppBundle:Media')->findAll();
		$media == null ? $medias = [] : $medias = $media;
		$viewVar['medias'] = $medias;

		return $viewVar;
	}

	protected function viewVariablesPublic($pageName)
	{
		$viewVar['pageTitle'] = "GetMoving - ".$pageName;

		$programs = $this->getDoctrine()->getRepository('AppBundle:Program')->findBy(array(
			'isActive' => true
		));
		$viewVar['programs'] = $programs;


		$profiles = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
		$viewVar['profiles'] = $profiles;

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];

			if ($currentOrg->getLogo() != null) {
				$logo = $this->getDoctrine()->getRepository('AppBundle:Media')->find($currentOrg->getLogo());
				$logo = $logo->getPath() . $logo->getFileName();
			}	else {
				$logo = "media/dummy.png";
			}

		} else {
			$logo = "media/dummy.png";
			$currentOrg = new Organisation();
		}
		$viewVar['organisation'] = $currentOrg;
		$viewVar['logo'] = DIRECTORY_SEPARATOR.$logo;

		return $viewVar;
	}
}
