<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Program;
use AppBundle\Entity\ProgramParticipants;
use AppBundle\Form\ParticipantType;
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
	public function programDetailAction($programId)
	{
		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$viewVar = $this->viewVariablesPublic($program->getTitle());
		$viewVar['program'] = $program;

		$participants = $this->getDoctrine()->getRepository('AppBundle:ProgramParticipants')->findBy(array('program' => $program));
		$viewVar['participants'] = count($participants);

		return $this->render('/programs/single.html.twig', $viewVar);
	}

	/**
	 * @Route("/{programId}/register", name="register_for_program")
	 */
	public function registerAction($programId, Request $request)
	{
		$viewVar = $this->viewVariablesPublic('Register');

		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$viewVar['program'] = $program;

//		$participant = new ProgramParticipants();
//		$participant->setProgram($program);


		$form = $this->createForm(UserRegistrationForm::class);
		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			$user = $form->getData();

			$user->setRoles(['ROLE_VOLUNTEER']);

//			$arrival = $_GET['arrivalDate'];
//			$duration = $form->getData()->getDuration();
//
//			$participant->setUser($user);
//			$participant->setArrivalDate($arrival);
//			$participant->setDuration($duration);
//			echo "<pre>";
//			print_r($user);
//			print_r($participant);
//			echo "</pre>";
//			die();

			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
//			$em->persist($participant);
			$em->flush();

			$psw = $form->getData()->getPlainPassword();

			$this->sendEmailUser($user, $psw);
			$this->sendEmailSystem($user);

			$this->addFlash('success', 'An email has been sent to you with your login information.');
			return $this->redirectToRoute('register_logged_in_for_program', array(
				'programId' => $programId,
				'userId' => $user->getId()
			));
		}

		$viewVar['form'] = $form->createView();
		return $this->render('/users/register.html.twig', $viewVar);
	}

	/**
	 * @Route("/{programId}/register/{userId}", name="register_logged_in_for_program")
	 */
	public function registerLoggedInAction($programId, $userId, Request $request)
	{
		$viewVar = $this->viewVariablesPublic('SignUp');
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($userId);
		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$participant = new ProgramParticipants();

		$form = $this->createForm(ParticipantType::class, $participant);

		$form->handleRequest($request);
		if ($form->isValid() && $form->isSubmitted())
		{
			$newParticipant = $form->getData();
			$newParticipant->setUser($user);
			$newParticipant->setProgram($program);

			$em = $this->getDoctrine()->getManager();
			$em->persist($newParticipant);
			$em->flush();

			$this->sendEmailUserParticipation($user, $newParticipant);
			$this->sendEmailSystemUserParticipation($user, $newParticipant);

			return $this->get("security.authentication.guard_handler")
				->authenticateUserAndHandleSuccess(
					$user,
					$request,
					$this->get("app.security.login_form_authenticator"),
					'main'
				);
		}

		$viewVar['form'] = $form->createView();
		return $this->render('/users/register_program.html.twig', $viewVar);
	}
}
