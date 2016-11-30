<?php

namespace AppBundle\Controller;

use AppBundle\Doctrine\UploadFileMoverListener;
use AppBundle\Entity\Identity;
use AppBundle\Entity\Media;
use AppBundle\Entity\Organisation;
use AppBundle\Entity\Program;
use AppBundle\Form\IdentityType;
use AppBundle\Form\OrganisationType;
use AppBundle\Form\ProgramType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
			$logo = new Media();
			$file = $form->getData()->getLogo();
			
			echo "<pre>";
			print_r($file);
			echo "</pre>";
		
			$d  = new \DateTime();
			$m = $d->format("m");
			$y = $d->format("Y");

			$upload_dir = "uploads/media-library";
			$sub_dir = $y . DIRECTORY_SEPARATOR . $m;



			// Verifies fif $request is a file
			if ( $file instanceof UploadedFile ) {
				if ( $file->getSize() < 2000000 ) {

					$originalName = $file->getClientOriginalName();
					$originalName = str_replace( ' ', '_', $originalName );

					$mime_type = $file->getMimeType();
					$type_array = explode( '/', $mime_type );
					$type_check = $type_array[ sizeof( $type_array ) - 1 ];

					$valid_filetypes = array( "jpg", "jpeg", "png", "mp4", "ogg", "mpeg", "quicktime" );

					if (in_array( strtolower( $type_check ), $valid_filetypes ) ) {
						$dateUploaded = new \DateTime("Pacific/Fiji");
						$month = $dateUploaded->format("m");
						$year = $dateUploaded->format("Y");

						$upload_dir = "uploads/media-library";
						$sub_dir = $year . DIRECTORY_SEPARATOR . $month;

						$size = $file->getSize();
						$format = $type_array[ 0 ];

						$logo->setPath($upload_dir . DIRECTORY_SEPARATOR . $sub_dir . DIRECTORY_SEPARATOR);
						$logo->setFileName($originalName);
						$logo->setSize($size);
						$logo->setFormat($format);

						$uploadFileMover = new UploadFileMoverListener();
						$uploadFileMover->moveUploadedFile($file, $upload_dir, $sub_dir, $originalName);

						$em = $this->getDoctrine()->getManager();
						$em->persist($logo);
						$em->flush();


						$this->addFlash('success', 'The cover pic has been uploaded!');
						return $this->redirectToRoute('admin_organisation');

					} else {
						print_r("Your file is not an image.");
					}

				} else {
					print_r("Your file can max be 2 MB of size");
				}

			} else {
				print_r($file);
			}

			// ... perform some action, such as saving the task to the database
			// for example, if Task is a Doctrine entity, save it!
			$em = $this->getDoctrine()->getManager();
			$em->persist($newOrganisation);
			$em->persist($logo);
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
