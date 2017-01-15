<?php

namespace AppBundle\Controller;

use AppBundle\Doctrine\UploadFileMoverListener;
use AppBundle\Entity\Document;
use AppBundle\Entity\Media;
use AppBundle\Entity\Organisation;
use AppBundle\Entity\Program;
use AppBundle\Entity\ProgramParticipants;
use AppBundle\Entity\User;
use AppBundle\Form\AdminType;
use AppBundle\Form\DocumentType;
use AppBundle\Form\MediaType;
use AppBundle\Form\OrganisationType;
use AppBundle\Form\ParticipantType;
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
//				echo "INSTANCE OF UPLOADFILE";
				if ($file->getSize() < 2000000) {

					$originalName = $file->getClientOriginalName();
					$originalName = str_replace(' ', '_', $originalName);
					$originalNameStart = $originalName;
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
			$logoId = $_POST['mediaOne-choosable'];
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
			$files = $form->getData()->getPath();
//
//			echo "<pre>";
//			print_r($files);
//			echo "</pre>";

			// Verifies if $request is a file
			foreach ($files as $file) {
				$media = new Media();

				echo "<pre>";
				print_r($file);
				echo "</pre>";

				if ($file instanceof UploadedFile) {
					if ($file->getSize() < 2000000) {

						$originalName = $file->getClientOriginalName();
						$originalName = str_replace(' ', '_', $originalName);
						$originalNameStart = $originalName;
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

						} else {
							print_r("Your file is not an image.");
						}

					} else {
						print_r("Your file can max be 2 MB of size");
					}

				} else {
					print_r($file);
				}
			}
			die();
			$this->addFlash('success', 'The media has been uploaded.');
			return $this->redirectToRoute('admin_media_library');
		}

		$viewVar['form'] = $form->createView();
		return $this->render('admin/medialibrary.html.twig', $viewVar);
	}

	/**
	 * @Route("/media/delete/{mediaId}", name="admin_media_delete")
	 */
	public function mediaDeleteAction($mediaId){
		$media = $this->getDoctrine()->getRepository('AppBundle:Media')->find($mediaId);

		$em = $this->getEntityManager();
		$em->remove($media);
		$em->flush();

		$this->addFlash('success', 'The media has successfully been deleted');
		return $this->redirectToRoute('admin_media_library');
	}








	/**
	 * @Route("/users", name="admin_users")
	 */
	public function usersAction()
	{
		$viewVar = $this->viewVariables("Users");

		$countries = json_decode(file_get_contents('../web/dist/countries.json'), true);
		foreach ($viewVar['users'] as $user) {
			foreach ($countries as $country) {
				if ($user->getNationality() == $country['cca3']) {
					$user->setNationality($country['demonym'] . ", " . $country['name']['common']);
					break;
				}
			}
			$role = $user->getRoles()[0];
			$aRole = explode("_", $role);
			$plainRole = $aRole[count($aRole)-1];
			$user->setRoles([$plainRole]);
		}

		return $this->render('admin/users.html.twig', $viewVar);
	}

	/**
	 * @Route("/user/new", name="admin_user_new")
	 */
	public function userAddAction(Request $request){
		$viewVar = $this->viewVariables("New user");

		$user = new User();

		$form = $this->createForm(AdminType::class, $user);

		$form->handleRequest($request);
		if ($form->isValid() && $form->isSubmitted()) {
			$newUser = $form->getData();
			$newUser->setRoles(['ROLE_ADMIN']);

			$em = $this->getEntityManager();
			$em->persist($newUser);
			$em->flush();

			$this->addFlash('success', 'The user has been created!');

			return $this->redirectToRoute('admin_users');
		}

		$viewVar['form'] = $form->createView();
		return 	$this->render('/admin/usersNew.html.twig', $viewVar);
	}

	/**
	 * @Route("/user/delete/{userId}/{Y}/{M}/{D}", name="admin_user_delete")
	 */
	public function userDeleteAction($userId, $Y, $M, $D, Request $request){
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($userId);

		if (!empty($user))
		{
			$em = $this->getDoctrine()->getManager();
			$em->remove($user);
			$em->flush();

			$this->addFlash("success", "The user ".$user->getFirstName()." ".$user->getLastName()." has been deleted!");
			return $this->redirectToRoute('admin_users');
		} else {
			$this->addFlash("error", "An error occurred. The user ".$user->getId()." could not be deleted through '".$Y." ".$M." ".$D."'. Contact IT-support or try again later.");
			return $this->redirectToRoute('admin_users');
		}
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

		$viewVar['volunteer'] = $volunteer;

		$form = $this->createForm(UserType::class, $volunteer);

		$form->handleRequest($request);
		if ($form->isValid() && $form->isSubmitted()) {
			$newVolunteer = $form->getData();

			$em = $this->getEntityManager();
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
	 * @Route("/volunteer/{volunteerId}/participations", name="admin_volunteer_participations")
	 */
	public function volunteerParticipationsAction($volunteerId, Request $request)
	{
		$volunteer = $this->getDoctrine()->getRepository('AppBundle:User')->find($volunteerId);
		$vFirstName = $volunteer->getFirstname();
		$vMiddleName = $volunteer->getMiddlename();
		$vLastName = $volunteer->getLastname();

		empty($vMiddleName) ? $vName = $vFirstName . " " . $vLastName : $vName = $vFirstName . " " . $vMiddleName . " " . $vLastName;

		$documentation = new Document();

		$participations = $this->getDoctrine()->getRepository('AppBundle:ProgramParticipants')
			->findBy(['user' => $volunteer]);

		$viewVar = $this->viewVariables($vName . " participations");
		$viewVar['volunteer'] = $volunteer;;

		$form_docs = [];
		foreach ($participations as $e) {
			$form_doc = $this->createForm(DocumentType::class, $documentation);
			$form_docs[] = $form_doc;

		}

		$target = 0;
		foreach ($form_docs as $key => $form_doc) {
			if ($form_doc->isSubmitted() && $form_doc->isValid()) {
				$target = $key;
				break;
			}
		}

		$form_docs[$target]->handleRequest($request);
		if ($form_docs[$target]->isSubmitted() && $form_docs[$target]->isValid()) {
			$form_doc = $form_docs[$target];
			$passport = $form_doc['passport']->getData();
			$criminalRecord = $form_doc['criminalRecord']->getData();
			$ticket = $form_doc['ticket']->getData();

			$newParticipation = $this->getDoctrine()->getRepository('AppBundle:ProgramParticipants')->find($participations[$target]->getId());

			$newUser = $volunteer;

			$files = [];
			if ( !empty($passport) ){ $files['passport'] = $passport; }
			if ( !empty($criminalRecord) ){ $files['criminalRecord'] = $criminalRecord; }
			if ( !empty($ticket) ){ $files['ticket'] = $ticket; }

			// Verifies if $request is a file
			foreach ($files as $key => $file) {
				$document = new Document();

//				echo "<pre>";
//				print_r($file);
//				echo "</pre>";

				if ($file instanceof UploadedFile) {
					$originalName = $file->getClientOriginalName();
					$originalName = str_replace(' ', '_', $originalName);
					$originalNameStart = $originalName;
					$unique = false;
					$count = 1;
					$docs = $this->getDoctrine()->getRepository('AppBundle:Document')->findAll();
					if (!empty($docs)) {
						do {
							foreach ($docs as $item){
								if ($item->getFileName() == $originalName) {
									$unique = false;
									$originalName = explode(".", $originalNameStart);
									$originalName[0] = $originalName[0].$count;
									$originalName = implode(".", $originalName);
									$count++;
	//								echo "false - ".$unique."<br>";
									break;
								} else {
									$unique = true;
	//								echo "true - ".$unique."<br>";
								}
	//							echo $unique . " - ". $originalName . " || <br>";
							}
						} while ($unique != true);
					}
					$upload_dir = "uploads/volunteer-documentations";
					$sub_dir = str_replace(" ", "-", $vName);

					$size = $file->getSize();

					$uploadFileMover = new UploadFileMoverListener();
					$uploadFileMover->moveUploadedFile($file, $upload_dir, $sub_dir, $originalName);


					$document->setPath($upload_dir . DIRECTORY_SEPARATOR . $sub_dir . DIRECTORY_SEPARATOR);
					$document->setFileName($originalName);
					$document->setSize($size);

					switch ($key) {
						case "passport":
							$type = "passport";
							$document->setType($type);
							$newUser->setPassport($document);
							break;

						case "criminalRecord":
							$type = "criminalRecord";
							$document->setType($type);
							$newUser->setCriminalRecord($document);
							break;

						case "ticket":
							$type = "ticket";
							$document->setType($type);
							$newParticipation->setPartitionTicketOut($document);
							break;
					}

					$em = $this->getDoctrine()->getManager();
					$em->persist($document);
					$em->persist($newUser);
					$em->persist($newParticipation);
					$em->flush();
					$this->addFlash("success", "The documentation for ".$type." has been added");
				} else {
					print_r($file);
					$this->addFlash("error", "An error occured in of the documents.");
				}
			}
		}

		foreach ($form_docs as $form_doc) {
			$viewVar['form_doc'][] = $form_doc->createView();
		}

		return	$this->render('admin/volunteerParticipations.html.twig', $viewVar);
	}

	/**
	 * @Route("/participation/{participationId}/{userId}/{programId}", name="admin_update_participation")
	 */
	public function updateParticipationAction($participationId, $userId, $programId)
	{
		$participation = $this->getDoctrine()->getRepository('AppBundle:ProgramParticipants')->find($participationId);

			if ($participation->getUser()->getId() == $userId && $participation->getProgram()->getId() == $programId)
		{
			$duration = $_GET['duration'];
			$arrival = $_GET['arrival'];
			$arrival = new \DateTime($arrival);

			$participation->setArrivalDate($arrival);
			$participation->setDuration($duration);

//			echo "<pre>";
//			print_r($participation);
//			echo "</pre>";

			$em = $this->getDoctrine()->getManager();
			$em->persist($participation);
			$em->flush();

			return $this->redirectToRoute('admin_volunteer_participations', array('volunteerId' => $userId));
		}
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
		$viewVar['program'] = $program;

		$media = new Media();
		$form = $this->createForm(ProgramType::class, $program);
		$formUpload = $this->createForm(MediaType::class, $media);

		$formUpload->handleRequest($request);
		$form->handleRequest($request);
		if ($formUpload->isSubmitted() && $formUpload->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$file = $formUpload->getData()->getPath();

			if ($file instanceof UploadedFile) {
//				echo "INSTANCE OF UPLOADFILE";
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
								break;
							} else {
								$unique = true;
							}
							echo $unique . " - ". $originalName . " || ";
						}
					} while ($unique != true);

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
						return $this->redirectToRoute('admin_program_new');

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
			return $this->redirectToRoute('admin_programs');
		}

		$viewVar['form'] = $form->createView();
		$viewVar['formUpload'] = $formUpload->createView();

		return $this->render('admin/programNew.html.twig', $viewVar);
	}

	/**
	 * @Route("/program/{programId}", name="admin_program_update")
	 */
	public function programUpdateAction($programId, Request $request)
	{
		$media = new Media();
		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$viewVar = $this->viewVariables("Program-".$program->getTitle());
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
					$originalName = str_replace(' ', '_', $originalName);
					$originalNameStart = $originalName;
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
