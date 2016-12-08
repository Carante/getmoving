<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\LoginForm;
use AppBundle\Form\ResetPasswordType;
use AppBundle\Form\RetrievePasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
	/**
	 * @Route("/login", name="security_login")
	 */
	public function loginAction()
	{
		$viewVar = $this->viewVariablesPublic("Login");

		$authenticationUtils = $this->get('security.authentication_utils');

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		$form = $this->createForm(LoginForm::class, array(
			'_username' => $lastUsername
		));

		$viewVar['form'] = $form->createView();
		$viewVar['error'] = $error;
		return $this->render('security/login.html.twig', $viewVar);
	}

	/**
	 * @Route("/logout", name="security_logout")
	 */
	public function logoutAction()
	{
		throw new \Exception('this should not be reached!');
	}

	/**
	 * @Route("/access_denied", name="security_access_denied")
	 */
	public function accessDeniedAction()
	{
		return $this->redirectToRoute('home');
	}

	/**
	 * @Route("/retrieve-password", name="security_retrieve_password")
	 */
	public function retrievePasswordAction(Request $request)
	{
		$viewVar = $this->viewVariablesPublic("Lost password");

		// last username entered by the user
		$form = $this->createForm(RetrievePasswordType::class, array());
		$viewVar['form'] = $form->createView();


		$form->handleRequest($request);
		if ($form->isValid() && $form->isSubmitted()) {
			$email = $form->getData()['email'];
			echo $email;
			$existing = false;
			foreach ($viewVar['profiles'] as $user){
				if ($user->getEmail() == $email) {
					$existing = true;
					$password = $user->getPassword();
					$userId = $user->getId();
					break;
				}

			}
			if ( $existing == true ){
				$this->sendPassword($email, $password, $userId);
				$this->addFlash('success', 'Check your email for the link for resetting your password');
				$this->redirectToRoute('security_login');
				return $this->redirectToRoute('security_login');
			}

			return $this->redirectToRoute('security_retrieve_password');

		}
		return $this->render('security/retrieve_password.html.twig', $viewVar);
	}

	/**
	 * @Route("/resetPassword/{userId}/{userToken}")
	 */
	public function resetPasswordAction($userId, $userToken, Request $request) {
		$viewVar = $this->viewVariablesPublic("Reset password");

		foreach ($viewVar['profiles'] as $user) {
			$userPsw = $this->getUrlFriendlyString($user->getPassword());
			if ($user->getId() == $userId && $userPsw == $userToken) {
				$profile = $this->getDoctrine()->getRepository('AppBundle:User')->find($userId);
				break;
			}
		}
		if (!$profile){
			throw $this->createNotFoundException(
				'No volunteer found :( '
			);
		}
		$form = $this->createForm(ResetPasswordType::class, $profile);

		$form->handleRequest($request);
		if ($form->isValid() && $form->isSubmitted()) {
			/** @var  User $user */
			$newVolunteer = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$em->persist($newVolunteer);
			$em->flush();

			$this->addFlash('success', 'The Volunteer has been updated'.$newVolunteer->getPlainPassword());
			return $this->redirectToRoute('admin_volunteers');
		}

			$viewVar['form'] = $form->createView();
			return $this->render('/reset_password.html.twig', $viewVar);
	}

	public function volunteerUpdateAction($volunteerId, Request $request)
	{

		$viewVar['form'] = $form->createView();

		return $this->render('admin/volunteerUpdate.html.twig', $viewVar);
	}



	public function sendPassword($email, $password, $id)
	{
		$GMmail = 'c.kaiser.p@gmail.com';
		$GMmailPassword = 'paustian';

		// http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
		$transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
			->setUsername($GMmail)
			->setPassword($GMmailPassword);
		$domain = "localhost:8000";
		$passwordUrl = $this->getUrlFriendlyString($password);

		$route = "http://".$domain.DIRECTORY_SEPARATOR."resetPassword".DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.$passwordUrl;
		$body = "Reset your password <a href='".$route."'>here</a>";

		$mailer = \Swift_Mailer::newInstance($transport);
		$message = \Swift_Message::newInstance('GetMoving - Retrieve lost password')
			->setFrom(array('contactform@fiji-getmoving.com' => 'GetMoving - Fiji'))
			->setTo(array($email => "GetMoving Support"))
			->setReplyTo(array('noReply@getmoving.com' => 'No Reply'))
			->setBody($body, 'text/html');

		return $mailer->send($message);
	}

	public function getUrlFriendlyString($string)
	{
		$string = mb_strtolower($string);
		$string = str_replace(array('ä','ö','ß','ü'), array('ae','oe','ss','ue'), $string);
		$string = preg_replace('#[^0-9a-z ]#', '', $string);
		$string = preg_replace('#\s\s+#', ' ', $string);
		$string = trim($string);
		$string = str_replace(' ', '-', $string);

		return $string;
	}
}
