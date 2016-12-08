<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseController
{
	/**
	 * @Route("/", name="home")
	 */
	public function indexAction() {
		$viewVar = $this->viewVariablesPublic("Welcome");

		return $this->render('home.html.twig', $viewVar);
	}

	/**
	 * @Route("/why", name="why")
	 */
	public function whyAction()
	{
		$viewVar = $this->viewVariablesPublic("Why?");

		return $this->render("why.html.twig", $viewVar);

	}

	/**
	 * @Route("/contact", name="contact")
	 */
	public function contactAction(Request $request)
	{
		$viewVar = $this->viewVariablesPublic("Connected");

		$organisation = $viewVar['organisation'];
		$socialcount = 0;
		!empty($organisation->getFacebook()) ? $socialcount++ : false ;
		!empty($organisation->getTwitter()) ? $socialcount++ : false ;
		!empty($organisation->getInstagram()) ? $socialcount++ : false ;
		!empty($organisation->getSnapchat()) ? $socialcount++ : false ;
		!empty($organisation->getYoutube()) ? $socialcount++ : false ;
		!empty($organisation->getGoogleplus()) ? $socialcount++ : false ;
		!empty($organisation->getLinkedin()) ? $socialcount++ : false ;


		($socialcount != 5 && $socialcount != 7) ? $socialDiv = 12 / $socialcount : ($socialcount == 5 ? $socialDiv = 15 : $socialcount = 17) ;
		$viewVar['socialDiv'] = $socialDiv;

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

		$viewVar['form'] = $form->createView();
		return $this->render('contact.html.twig', $viewVar);
	}

	private function sendEmail($data){
		$GMmail = 'c.kaiser.p@gmail.com';
		$GMmailPassword = 'paustian';

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
