<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\ContactType;
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
	 * @Route("/why", name="why")
	 */
	public function whyAction(Request $request)
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

			return $this->redirectToRoute("home", array(
				'pageTitle' => "Why GetMoving?"
			));
		}

		return $this->render("why.html.twig", array(
			'form' => $form->createView(),
			'pageTitle' => "Why GetMoving?"
		));

	}

	/**
	 * @Route("/contact", name="contact")
	 */
	public function contactAction(Request $request)
	{
		// Create the form according to the FormType created previously.
		// And give the proper parameters
		$form = $this->createForm(ContactType::class, null,array(
			// To set the action use $this->generateUrl('route_identifier')
			'action' => $this->generateUrl('contact'),
			'method' => 'POST'
		));

		if ($request->isMethod('POST')) {
			// Refill the fields in case the form is not valid.
			$form->handleRequest($request);

			if($form->isValid()){
				// Send mail
				if($this->sendEmail($form->getData())){

					// Everything OK, redirect to wherever you want ! :

					return $this->redirectToRoute('home');
				}else{
					// An error ocurred, handle
					var_dump("Errooooor :(");
				}
			}
		}

		return $this->render('contact.html.twig', array(
			'form' => $form->createView(),
			'pageTitle' => "Get connected!"
		));
	}

	private function sendEmail($data){
		$GMmail = 'c.kaiser.p@gmail.com';
		$GMmailPassword = 'paustian';

		// In this case we'll use the ZOHO mail services.
		// If your service is another, then read the following article to know which smpt code to use and which port
		// http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
		$transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
			->setUsername($GMmail)
			->setPassword($GMmailPassword);

		$mailer = \Swift_Mailer::newInstance($transport);
		$message = \Swift_Message::newInstance($data['subject'])
			->setFrom(array('contactform@fiji-getmoving.com' => $data['name']))
			->setTo(array($GMmail => "GetMoving Support"))
			->setReplyTo(array($data['email'] => $data['name']))
			->setBody($data['message'], 'text/html');

		return $mailer->send($message);
	}


}
