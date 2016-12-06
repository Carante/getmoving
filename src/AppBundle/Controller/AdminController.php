<?php

namespace AppBundle\Controller;

use AppBundle\Doctrine\UploadFileMoverListener;
use AppBundle\Entity\Media;
use AppBundle\Entity\Organisation;
use AppBundle\Entity\Program;
use AppBundle\Form\MediaType;
use AppBundle\Form\OrganisationType;
use AppBundle\Form\ProgramType;
use AppBundle\Form\UserRegistrationForm;
use AppBundle\Form\UserType;
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
	 * @Route("/settings", name="admin_settings")
	 */
	public function settingsAction()
	{
		$viewVar = $this->viewVariables("Settings");

		return $this->render('admin/settings.html.twig', $viewVar);
	}


	/**
	 * @Route("/organisation", name="admin_organisation")
	 */
	public function organisationAction(Request $request)
	{
		$viewVar = $this->viewVariables("Organisation");

		$org = new Organisation();
		$media = new Media();
		$form = $this->createForm(OrganisationType::class, $org);
		$formUpload = $this->createForm(MediaType::class, $media);

		$formUpload->handleRequest($request);
		if ($formUpload->isSubmitted() && $formUpload->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$file = $formUpload->getData()->getPath();
			echo "<pre>";
			print_r($file);
			echo "</pre>";
			// Verifies if $request is a file
			if ($file instanceof UploadedFile) {
				echo "INSTANCE OF UPLOADFILE";
				if ($file->getSize() < 2000000) {

					$originalName = $file->getClientOriginalName();
					$originalName = str_replace(' ', '_', $originalName);

					$mime_type = $file->getMimeType();
					$type_array = explode('/', $mime_type);
					$type_check = $type_array[sizeof($type_array) - 1];

					$valid_filetypes = array("jpg", "jpeg", "png", "mp4", "ogg", "mpeg", "quicktime");

					if (in_array(strtolower($type_check), $valid_filetypes)) {
						$dateUploaded = new \DateTime("Pacific/Fiji");
						$month = $dateUploaded->format("m");
						$year = $dateUploaded->format("Y");

						$upload_dir = "uploads/media-library";
						$sub_dir = $year . DIRECTORY_SEPARATOR . $month;

						$size = $file->getSize();
						$format = $type_array[0];

						$media->setPath($upload_dir . DIRECTORY_SEPARATOR . $sub_dir . DIRECTORY_SEPARATOR);
						$media->setFileName($originalName);
						$media->setSize($size);
						$media->setFormat($format);

						$uploadFileMover = new UploadFileMoverListener();
						$uploadFileMover->moveUploadedFile($file, $upload_dir, $sub_dir, $originalName);

						$em = $this->getDoctrine()->getManager();
						$em->persist($media);
						$em->flush();

						$this->addFlash('success', 'The image has been uploaded!');
						return $this->redirectToRoute('admin_organisation');

					} else {
						print_r("Your file is not an image.");
					}

				} else {
					print_r("Your file can max be 2 MB of size");
				}
			}
		}

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$newOrganisation = $form->getData();
			$logoId = $_POST['logo-choosable'];
			$logo = $this->getDoctrine()->getRepository('AppBundle:Media')->find($logoId);

			$newOrganisation->setLogo($logo);

			$em = $this->getDoctrine()->getManager();
			$em->persist($newOrganisation);
			$em->flush();

			$this->addFlash('success', 'The organisations details has been saved.');
			return $this->redirectToRoute('admin_organisation');
		}

		$viewVar['form'] = $form->createView();
		$viewVar['formUpload'] = $formUpload->createView();
		return $this->render('admin/organisation.html.twig', $viewVar);
	}


	/**
	 * @Route("/medialibrary", name="admin_media_library")
	 */
	public function mediaLibraryAction(Request $request)
	{
		$viewVar = $this->viewVariables("Media library");

		$media = new Media();

		$form = $this->createForm(MediaType::class, $media);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$file = $form->getData()->getPath();

			echo "<pre>";
			print_r($file);
			echo "</pre>";

			// Verifies if $request is a file
			if ($file instanceof UploadedFile) {
				if ($file->getSize() < 2000000) {

					$originalName = $file->getClientOriginalName();
					$originalName = str_replace(' ', '_', $originalName);

					$mime_type = $file->getMimeType();
					$type_array = explode('/', $mime_type);
					$type_check = $type_array[sizeof($type_array) - 1];

					$valid_filetypes = array("jpg", "jpeg", "png", "mp4", "ogg", "mpeg", "quicktime");

					if (in_array(strtolower($type_check), $valid_filetypes)) {
						$dateUploaded = new \DateTime();
						$month = $dateUploaded->format("m");
						$year = $dateUploaded->format("Y");

						$upload_dir = "uploads/media-library";
						$sub_dir = $year . DIRECTORY_SEPARATOR . $month;

						$size = $file->getSize();
						$format = $type_array[0];

						$media->setPath($upload_dir . DIRECTORY_SEPARATOR . $sub_dir . DIRECTORY_SEPARATOR);
						$media->setFileName($originalName);
						$media->setSize($size);
						$media->setFormat($format);

						$uploadFileMover = new UploadFileMoverListener();
						$uploadFileMover->moveUploadedFile($file, $upload_dir, $sub_dir, $originalName);

						$em = $this->getDoctrine()->getManager();
						$em->persist($media);
						$em->flush();


						$this->addFlash('success', 'The cover pic has been uploaded!');
						return $this->redirectToRoute('admin_media_library');

					} else {
						print_r("Your file is not an image.");
					}

				} else {
					print_r("Your file can max be 2 MB of size");
				}

			} else {
				print_r($file);
			}

			$this->addFlash('success', 'The media has been uploaded.');
			return $this->redirectToRoute('admin_media_library');
		}

		$viewVar['form'] = $form->createView();
		return $this->render('admin/medialibrary.html.twig', $viewVar);
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
	 * @Route("/profile", name="admin_profile")
	 */
	public function profileAction()
	{
		$viewVar = $this->viewVariables("Profile");

		return $this->render('admin/userProfile.html.twig', $viewVar);
	}


	/**
	 * @Route("/volunteers", name="admin_volunteers")
	 */
	public function volunteersAction()
	{
		$viewVar = $this->viewVariables("Volunteers");

		$countries = json_decode(file_get_contents('../web/dist/countries.json'), true);
		foreach ($viewVar['volunteers'] as $volunteer) {
			foreach ($countries as $country) {
				if ($volunteer->getNationality() == $country['cca3']) {
					$volunteer->setNationality($country['demonym'] . ", " . $country['name']['common']);
					break;
				}

			}
		}


		return $this->render('admin/volunteers.html.twig', $viewVar);
	}

	/**
	 * @Route("/volunteer/{volunteerId}", name="admin_volunteer_edit")
	 */
	public function volunteerUpdateAction($volunteerId, Request $request)
	{
		$volunteer = $this->getDoctrine()->getRepository('AppBundle:User')->find($volunteerId);
		$vFirstName = $volunteer->getFirstname();
		$vMiddleName = $volunteer->getMiddlename();
		$vLastName = $volunteer->getLastname();

		empty($vMiddleName) ? $vName = $vFirstName . " " . $vLastName : $vName = $vFirstName . " " . $vMiddleName . " " . $vLastName;

		$viewVar = $this->viewVariables($vName);

		$viewVar['volunteer'] = $volunteer;;

		$form = $this->createForm(UserType::class, $volunteer);

		$form->handleRequest($request);
		if ($form->isValid() && $form->isSubmitted()) {
			$newVolunteer = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$em->persist($newVolunteer);
			$em->flush();

			$this->addFlash('success', 'The Volunteer has been updated');
			return $this->redirectToRoute('admin_volunteers');
		}

		if (!$volunteer) {
			throw $this->createNotFoundException(
				'No volunteer found :( '
			);
		}
		$viewVar['form'] = $form->createView();

		return $this->render('admin/volunteerUpdate.html.twig', $viewVar);
	}


	/**
	 * @Route("/programs", name="admin_programs")
	 */
	public function programsAction()
	{
		$viewVar = $this->viewVariables("Programs");

		return $this->render('admin/programs.html.twig', $viewVar);
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
			$feature = new Media();
			$file = $form->getData()->getLogo()->getPath();
			$galleryMedia = $form->getData()['program_media_paths'];

			$newProgram->addProgramMedia($galleryMedia);

			echo "<pre>";
			print_r($file);
			echo "</pre>";

			// Verifies if $request is a file
			if ($file instanceof UploadedFile) {
				echo "INSTANCE OF UPLOADFILE";
				if ($file->getSize() < 2000000) {

					$originalName = $file->getClientOriginalName();
					$originalName = str_replace(' ', '_', $originalName);

					$mime_type = $file->getMimeType();
					$type_array = explode('/', $mime_type);
					$type_check = $type_array[sizeof($type_array) - 1];

					$valid_filetypes = array("jpg", "jpeg", "png");

					if (in_array(strtolower($type_check), $valid_filetypes)) {
						$dateUploaded = new \DateTime("Pacific/Fiji");
						$month = $dateUploaded->format("m");
						$year = $dateUploaded->format("Y");

						$upload_dir = "uploads/media-library";
						$sub_dir = $year . DIRECTORY_SEPARATOR . $month;

						$size = $file->getSize();
						$format = $type_array[0];

						$feature->setPath($upload_dir . DIRECTORY_SEPARATOR . $sub_dir . DIRECTORY_SEPARATOR);
						$feature->setFileName($originalName);
						$feature->setSize($size);
						$feature->setFormat($format);

						$uploadFileMover = new UploadFileMoverListener();
						$uploadFileMover->moveUploadedFile($file, $upload_dir, $sub_dir, $originalName);

						$newProgram->setFeature($feature);

						$em = $this->getDoctrine()->getManager();
						$em->persist($feature);
						$em->persist($newProgram);
						$em->flush();

						$this->addFlash('success', 'The cover pic has been uploaded!');
						return $this->redirectToRoute('admin_programs');

					} else {
						print_r("Your file is not an image.");
					}

				} else {
					print_r("Your file can max be 2 MB of size");
				}

			} else {
				print_r($file);
			}

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

		$media = new Media();
		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$viewVar['program'] = $program;


		$form = $this->createForm(ProgramType::class, $program);
		$formUpload = $this->createForm(MediaType::class, $media);

		$formUpload->handleRequest($request);
		$form->handleRequest($request);
		if ($formUpload->isSubmitted() && $formUpload->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$file = $formUpload->getData()->getPath();
			echo "<pre>";
			print_r($file);
			echo "</pre>";
			// Verifies if $request is a file
			if ($file instanceof UploadedFile) {
				echo "INSTANCE OF UPLOADFILE";
				if ($file->getSize() < 2000000) {

					$originalName = $file->getClientOriginalName();
					$originalNameStart = str_replace(' ', '_', $originalName);
					$unique = false;
					$count = 1;

					do {
						foreach ($viewVar['medias'] as $item){
							if ($item->getFileName() == $originalName) {
								$unique = false;
								$originalName = explode(".", $originalNameStart);
								$originalName[0] = $originalName[0].$count;
								$originalName = implode(".", $originalName);
								$count++;
//								echo $count;
								break;
							} else {
								$unique = true;
							}
							echo $unique . " - ". $originalName . " || ";
						}
					} while ($unique != true);

//					die();
					$mime_type = $file->getMimeType();
					$type_array = explode('/', $mime_type);
					$type_check = $type_array[sizeof($type_array) - 1];

					$valid_filetypes = array("jpg", "jpeg", "png", "mp4", "ogg", "mpeg", "quicktime");

					if (in_array(strtolower($type_check), $valid_filetypes)) {
						$dateUploaded = new \DateTime("Pacific/Fiji");
						$month = $dateUploaded->format("m");
						$year = $dateUploaded->format("Y");

						$upload_dir = "uploads/media-library";
						$sub_dir = $year . DIRECTORY_SEPARATOR . $month;

						$size = $file->getSize();
						$format = $type_array[0];

						$media->setPath($upload_dir . DIRECTORY_SEPARATOR . $sub_dir . DIRECTORY_SEPARATOR);
						$media->setFileName($originalName);
						$media->setSize($size);
						$media->setFormat($format);

						$uploadFileMover = new UploadFileMoverListener();
						$uploadFileMover->moveUploadedFile($file, $upload_dir, $sub_dir, $originalName);

						$em = $this->getDoctrine()->getManager();
						$em->persist($media);
						$em->flush();

						$this->addFlash('success', 'The image has been uploaded!');
						return $this->redirectToRoute('admin_program_update', array('programId' => $programId));

					} else {
						print_r("Your file is not an image.");
					}

				} else {
					print_r("Your file can max be 2 MB of size");
				}
			}
		} else if ($form->isValid() && $form->isSubmitted()) {
			$newProgram = $form->getData();
			$galleryMedia = $_POST['program_media'];
			$curGallery = $newProgram->getProgramMedia();
			foreach ($curGallery as $item) {
				$newProgram->removeProgramMedia($item);
			}
			foreach ($galleryMedia as $item) {
				$media = $this->getDoctrine()->getRepository('AppBundle:Media')->find($item);
				$newProgram->addProgramMedia($media);
			}

			$featureId = $_POST['mediaOne-choosable'];
			$feature = $this->getDoctrine()->getRepository('AppBundle:Media')->find($featureId);

			$newProgram->setFeature($feature);

			$em = $this->getDoctrine()->getManager();
			$em->persist($newProgram);
			$em->flush();

			$this->addFlash('success', 'The organisations details has been saved.');
		}


		if (!$program) {
			throw $this->createNotFoundException(
				'No program found :( '
			);
		}

		$viewVar['form'] = $form->createView();
		$viewVar['formUpload'] = $formUpload->createView();

		return $this->render('admin/programUpdate.html.twig', $viewVar);
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
