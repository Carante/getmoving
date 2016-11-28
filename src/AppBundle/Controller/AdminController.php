<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Identity;
use AppBundle\Entity\Media;
use AppBundle\Entity\Organisation;
use AppBundle\Form\IdentityType;
use AppBundle\Form\OrganisationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController extends Controller
{
	private function viewVariables($pageName) {
		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];

			$orgName = $currentOrg->getName();
		}
		$orgName = "Dummy";
		$viewVar = array(
			'pageTitle' => $pageName."|GetMoving",
			'orgName' => $orgName
		);

		return $viewVar;
	}
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

		$identities = $this->getDoctrine()->getRepository('AppBundle:Identity')->findAll();
		$count = count($identities)-1;
		$currentIdentity = $identities[$count];
		$identity = new Identity();

		$form = $this->createForm(IdentityType::class, $identity);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$newIdentity = $form->getData();
//			$newMedia = new Media();
//			$media = $form->getData()->getPath();

//			echo "<pre>";
//			print_r($media);
//			echo "</pre>";

			$d  = new \DateTime();
			$m = $d->format("m");
			$y = $d->format("Y");

			$upload_dir = "uploads/media-library";
			$sub_dir = $y . DIRECTORY_SEPARATOR . $m;

			//$size = $file->getSize();
			//$format = $type_array[ 0 ];

//			$newMedia->setPath($upload_dir . DIRECTORY_SEPARATOR . $sub_dir . DIRECTORY_SEPARATOR);
//			$newMedia->setFileName("fiji.jpg");
//			$newMedia->setSize(305901);
//			$newMedia->setFormat("image");
//			$newMedia->setTitle("Testing Logo Relation");

//			$newPost->setCover($media);

			// ... perform some action, such as saving the task to the database
			// for example, if Task is a Doctrine entity, save it!
			$em = $this->getDoctrine()->getManager();
			$em->persist($newIdentity);
//			$em->persist($media);
			$em->flush();

			$this->addFlash('success', 'The new awesome article has been created.');
			return $this->redirectToRoute('admin_identity');
		}

		$viewVar['form'] = $form->createView();
		$viewVar['identity'] = $currentIdentity;

		return $this->render('admin/identity.html.twig', $viewVar);
	}

	/**
	 * @Route("/organisation", name="admin_organisation")
	 */
	public function organisationAction(Request $request)
	{
		$viewVar = $this->viewVariables("Organisation");

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();

			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];
			$viewVar['organisation'] = $currentOrg;

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

		return $this->render('admin/programs.html.twig',$viewVar);
	}

	/**
	 * @Route("/programs/new", name="admin_program_new")
	 */
	public function programNewAction()
	{
		$viewVar = $this->viewVariables("New Program");

		return $this->render('admin/programNew.html.twig', $viewVar);
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
