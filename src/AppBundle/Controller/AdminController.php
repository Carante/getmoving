<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController extends Controller
{
	/**
	 * @Route("/", name="admin_dashboard")
	 */
	public function indexAction()
	{
		return $this->render('admin/home.html.twig', array(
			'pageTitle' => "Dashboard|GetMoving"
		));
	}

	/**
	 * @Route("/brand", name="admin_identity")
	 */
	public function brandAction()
	{
		return $this->render('admin/identity.html.twig', array(
			'pageTitle' => 'Brand|GetMoving'
		));
	}

	/**
	 * @Route("/organisation", name="admin_organisation")
	 */
	public function organisationAction()
	{
		return $this->render('admin/organisation.html.twig', array(
			'pageTitle' => 'Brand|GetMoving'
		));
	}

	/**
	 * @Route("/users", name="admin_users")
	 */
	public function usersAction()
	{
		return $this->render('admin/users.html.twig', array(
			'pageTitle' => 'Users|GetMoving'
		));
	}

	/**
	 * @Route("/volunteers", name="admin_volunteers")
	 */
	public function volunteersAction()
	{
		return $this->render('admin/volunteers.html.twig', array(
			'pageTitle' => 'Brand|GetMoving'
		));
	}

	/**
	 * @Route("/programs", name="admin_programs")
	 */
	public function programsAction()
	{
		return $this->render('admin/programs.html.twig', array(
			'pageTitle' => 'Brand|GetMoving'
		));
	}

	/**
	 * @Route("/programs/new", name="admin_program_new")
	 */
	public function programNewAction()
	{
		return $this->render('admin/programNew.html.twig', array(
			'pageTitle' => 'New Program|GetMoving'
		));
	}

	/**
	 * @Route("/profile", name="admin_profile")
	 */
	public function profileAction()
	{
		return $this->render('admin/userProfile.html.twig', array(
			'pageTitle' => 'Profile|GetMoving'
		));
	}

	/**
	 * @Route("/settings", name="admin_settings")
	 */
	public function settingsAction()
	{
		return $this->render('admin/settings.html.twig', array(
			'pageTitle' => 'Settings|GetMoving'
		));
	}

	/**
	 * @Route("/help", name="admin_help")
	 */
	public function helpAction()
	{
		return $this->render('admin/help.html.twig', array(
			'pageTitle' => 'Help|GetMoving'
		));
	}

}
