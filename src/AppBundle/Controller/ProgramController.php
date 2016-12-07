<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Program;
use AppBundle\Form\UserRegistrationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

	/**
	 * @Route("/{programId}", name="program_details")
	 */
	public function programDetailAction($programId){
		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$viewVar = $this->viewVariablesPublic($program->getTitle());
		$viewVar['program'] = $program;

		$participants = $program->getProgramParticipant();
		$viewVar['participants'] = count($participants);

		return $this->render('/programs/single.html.twig', $viewVar);
	}

	/**
	 * @Route("/{programId}/register", name="register_for_program")
	 */
	public function registerAction($programId, Request $request)
	{
		$viewVar = $this->viewVariablesPublic('SignUp');

		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$viewVar['program'] = $program;

		$form = $this->createForm(UserRegistrationForm::class);
		$form->handleRequest($request);

		if ($form->isValid() ) {
			$user = $form->getData();

			$program->addProgramParticipant($user);

			$user->setRoles(['ROLE_VOLUNTEER']);

			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			return $this->get("security.authentication.guard_handler")
				->authenticateUserAndHandleSuccess(
					$user,
					$request,
					$this->get("app.security.login_form_authenticator"),
					'main'
				);
		}

		$viewVar['form'] = $form->createView();
		return $this->render('/users/register.html.twig', $viewVar);
	}
}
