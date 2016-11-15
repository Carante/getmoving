<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseController
{
	/**
	 * @Route("/", name="home")
	 */
	public function indexAction() {

		return $this->render('home.html.twig');
	}

	/**
	 * @Route("/about", name="about_us")
	 */
	public function aboutAction() {
		return $this->render('/about.html.twig', array());
	}

	/**
	 * @Route("/why", name="why")
	 */
	public function whyAction()
	{
		return $this->render("why.html.twig", array());

	}

	/**
	 * @Route("/contact", name="contact")
	 */
	public function contactAction()
	{
		return $this->render("contact.html.twig", array());

	}


}
