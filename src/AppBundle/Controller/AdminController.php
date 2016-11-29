<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Identity;
use AppBundle\Entity\Media;
use AppBundle\Entity\Organisation;
use AppBundle\Entity\Program;
use AppBundle\Form\IdentityType;
use AppBundle\Form\OrganisationType;
use AppBundle\Form\ProgramType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController extends BaseController
{
	/**
	 * @Route("/", name="admin_dashboard")
	 */
	public function indexAction()
	{
		$viewVar = $this->viewVariables("Dashboard");

		return $this->render('admin/home.html.twig', $viewVar);
	}

	/**
	 * @Route("/identity", name="admin_identity")
	 */
	public function identityAction(Request $request)
	{
		$viewVar = $this->viewVariables("Identity");


		$identity = new Identity();

		$form = $this->createForm(IdentityType::class, $identity);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$newIdentity = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$em->persist($newIdentity);
			$em->flush();

			$this->addFlash('success', 'The new awesome article has been created.');
			return $this->redirectToRoute('admin_identity');
		}

		$viewVar['form'] = $form->createView();
		return $this->render('admin/identity.html.twig', $viewVar);
	}

	/**
	 * @Route("/organisation", name="admin_organisation")
	 */
	public function organisationAction(Request $request)
	{
		$viewVar = $this->viewVariables("Organisation");

		$org = new Organisation();
		$form = $this->createForm(OrganisationType::class, $org);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$newOrganisation = $form->getData();

			// ... perform some action, such as saving the task to the database
			// for example, if Task is a Doctrine entity, save it!
			$em = $this->getDoctrine()->getManager();
			$em->persist($newOrganisation);
			$em->flush();

			$this->addFlash('success', 'The organisations details has been saved.');
			return $this->redirectToRoute('admin_organisation');
		}

		$viewVar['form'] = $form->createView();
		return $this->render('admin/organisation.html.twig', $viewVar);
	}

	/**
	 * @Route("/users", name="admin_users")
	 */
	public function usersAction()
	{
		$viewVar = $this->viewVariables("Users");

		return $this->render('admin/users.html.twig', $viewVar);
	}

	/**
	 * @Route("/volunteers", name="admin_volunteers")
	 */
	public function volunteersAction()
	{
		$viewVar = $this->viewVariables("Volunteers");

		$volunteers = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

		$viewVar['volunteers'] = $volunteers;
		return $this->render('admin/volunteers.html.twig', $viewVar);
	}

	/**
	 * @Route("/programs", name="admin_programs")
	 */
	public function programsAction()
	{
		$viewVar = $this->viewVariables("Programs");

		$programs = $this->getDoctrine()->getRepository("AppBundle:Program")->findAll();
		$viewVar['programs'] = $programs;
		return $this->render('admin/programs.html.twig',$viewVar);
	}

	/**
	 * @Route("/program/new", name="admin_program_new")
	 */
	public function programNewAction(Request $request)
	{
		$viewVar = $this->viewVariables("New Program");

		$program = new Program();
		$form = $this->createForm(ProgramType::class, $program);
		$viewVar['form'] = $form->createView();
		$viewVar['program'] = $program;

		$form->handleRequest($request);
		if ($form->isValid() && $form->isSubmitted()) {
			$newProgram = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$em->persist($newProgram);
			$em->flush();

			$this->addFlash('success', 'The program has been created');
			return $this->redirectToRoute('admin_programs');
		}

		return $this->render('admin/programNew.html.twig', $viewVar);
	}

	/**
	 * @Route("/program/{programId}", name="admin_program_update")
	 */
	public function programUpdateAction($programId, Request $request)
	{
		$viewVar = $this->viewVariables("New Program");

		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$viewVar['program'] = $program;

		$form = $this->createForm(ProgramType::class, $program);

		$form->handleRequest($request);
		if ($form->isValid() && $form->isSubmitted()) {
			$newProgram = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$em->persist($newProgram);
			$em->flush();

			$this->addFlash('success', 'The program has been created');
			return $this->redirectToRoute('admin_programs');
		}

		if (!$program) {
			throw $this->createNotFoundException(
				'No program found :( '
			);
		}
		$viewVar['form'] = $form->createView();

		return $this->render('admin/programUpdate.html.twig', $viewVar);
	}

	/**
	 * @Route("/profile", name="admin_profile")
	 */
	public function profileAction()
	{
		$viewVar = $this->viewVariables("Profile");

		return $this->render('admin/userProfile.html.twig', $viewVar);
	}

	/**
	 * @Route("/settings", name="admin_settings")
	 */
	public function settingsAction()
	{
		$viewVar = $this->viewVariables("Settings");

		return $this->render('admin/settings.html.twig', $viewVar);
	}

	/**
	 * @Route("/help", name="admin_help")
	 */
	public function helpAction()
	{
		$viewVar = $this->viewVariables("Help");

		return $this->render('admin/help.html.twig', $viewVar);
	}

}
