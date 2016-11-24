<?php

namespace AppBundle\Controller;



use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends BaseController
{
	/**
	 * @Route("/login", name="user_login")
	 */
	public function loginAction() {
		return $this->render('/users/login.html.twig', array());
	}

	/**
	 * @Route("/signup", name="user_signup")
	 */
	public function signupAction(Request $request)
	{
		$user = new User();

		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);
		if ($form->isValid()) {
			// todo - Save new user
			$em = $this->getEntityManager();
			$em->persist($user);
			$em->flush();

			$this->addFlash('success', 'User has successfully been saved');

			return $this->redirectToRoute("users_list", array());
		}

		return $this->render('users/signup.html.twig', array(
		    'pageTitle' => 'GetMoving - Sign up',
			'form' => $form->createView()
		));
	}

	/**
	 * @Route("/users", name="users_list")
	 */
	public function listAction() {
		$users = $this->getEntityManager();
		$data = $users->getRepository('AppBundle:User')
			->findAll();

		return $this->render('users/show.html.twig', array(
			'users' => $data
		));
	}
}
