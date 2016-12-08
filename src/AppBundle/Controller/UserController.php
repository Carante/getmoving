<?php

namespace AppBundle\Controller;



use AppBundle\Entity\User;
use AppBundle\Form\UserRegistrationForm;
use Faker\Provider\cs_CZ\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class UserController extends BaseController
{
	/**
	 * @Route("/{firstName}-{lastName}", name="profile")
	 */
	public function profileAction($firstName, $lastName){
		$user = $this->getUser();
		$uFirstName = $user->getFirstName();
		$uLastName = $user->getLastName();
		$viewVar = $this->viewVariablesPublic($uFirstName." ".$uLastName);

		if ($firstName == $uFirstName && $lastName == $uLastName)
		{
			return $this->render('/users/profile.html.twig', $viewVar);
		}

		return $this->redirectToRoute('home');
	}


	/**
	 * @Route("/newTest")
	 */
	public function newAction(){
		$em = $this->getDoctrine()->getManager();

		$user = new User();
		$user->setFirstName("Participant");
		$user->setLastName("Test".rand(1, 100));
		$user->setSex(1);
    $user->setNationality('DNK');
    $user->setEmail('c.kaiser.p'.rand(20,2000).'@tester.dk');
    $user->setPhone('21469172');
    $user->setAddressCountry('DNK');
    $user->setAddressRegion('Copenhagen');
    $user->setAddressCity('Søborg');
    $user->setAddressZip('2860');
    $user->setAddressStreet('Søborg Hovedgade');
    $user->setAddressHouseNo('207');
    $user->setEduLevelExpected('Bachelor');
    $user->setEduCurrentPlace('KEA');
    $user->setEduCurrentProgram('Web Development');
    $user->setPlainPassword('turtles');
    $user->setRoles(['ROLE_VOLUNTEER']);

		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->findOneBy(['id' => 1]);

		$program->addProgramParticipant($user);

		$em->persist($user);
		$em->flush();

		$print = "<pre>";
		$print .= print_r($user);
		$print .= "</pre>";

		return ;

	}
}
