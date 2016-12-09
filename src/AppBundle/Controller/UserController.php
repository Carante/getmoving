<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserRegistrationForm;
use AppBundle\Form\UserType;
use Faker\Provider\cs_CZ\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class UserController extends BaseController
{
	/**
	 * @Route("/{firstName}-{lastName}", name="profile")
	 */
	public function profileAction($firstName, $lastName)
	{
		$user = $this->getUser();
		$uFirstName = $user->getFirstName();
		$uLastName = $user->getLastName();
		$viewVar = $this->viewVariablesPublic($uFirstName . " " . $uLastName);

		if ($firstName == $uFirstName && $lastName == $uLastName) {
			$viewVar['user'] = $user;

			$countries = json_decode(file_get_contents('../web/dist/countries.json'), true);
			foreach ($countries as $country) {
				if ($user->getNationality() == $country['demonym']) {
					$user->setNationality($country['demonym'] . ", " . $country['name']['common']);
					break;
				}
			}
			return $this->render('/users/profile.html.twig', $viewVar);
		}


		return $this->redirectToRoute('home');
	}

	/**
	 * @Route("/{firstName}-{lastName}/update", name="profile_update")
	 */
	public function editProfileAction($firstName, $lastName, Request $request)
	{
		$user = $this->getUser();
		$uFirstName = $user->getFirstName();
		$uLastName = $user->getLastName();
		$viewVar = $this->viewVariablesPublic($uFirstName . " " . $uLastName."| Update");

		if ($firstName == $uFirstName && $lastName == $uLastName) {
			$form = $this->createForm(UserType::class, $user);
			$viewVar['user'] = $user;

			$countries = json_decode(file_get_contents('../web/dist/countries.json'), true);
			foreach ($countries as $country) {
				if ($user->getNationality() == $country['demonym']) {
					$user->setNationality($country['demonym'] . ", " . $country['name']['common']);
					break;
				}
			}

			$form->handleRequest($request);
			if ($form->isSubmitted() && $form->isValid())
			{
				$newUser = $form->getData();

				$em = $this->getDoctrine()->getManager();
				$em->persist($newUser);
				$em->flush();

				return $this->redirectToRoute('profile', array(
					'firstName' => $user->getFirstName(),
					'lastName' => $user->getLastName()
				));
			}

			$viewVar['form'] = $form->createView();
			return $this->render('/users/profileUpdate.html.twig', $viewVar);
		}

		return $this->redirectToRoute('home');
	}

	/**
	 * @Route("/{userId}/resign/{programId}", name="user_resign_program")
	 */
	public function resignAction($programId, $userId)
	{
		$program = $this->getDoctrine()->getRepository('AppBundle:Program')->find($programId);
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($userId);

		$participant = $this->getDoctrine()->getRepository('AppBundle:ProgramParticipants')->findOneBy(array(
			'program' => $program,
			'user' => $user
		));

		$em = $this->getDoctrine()->getManager();
		$em->remove($participant);
		$em->flush();

		$this->addFlash('success', 'You have succesfully resigned from the program');
		return $this->redirectToRoute('profile', array(
				'firstName' => $user->getFirstName(),
				'lastName' => $user->getLastName()
			)
		);

	}


	/**
	 * @Route("/newTest")
	 */
	public function newAction()
	{
		$em = $this->getDoctrine()->getManager();

		$user = new User();
		$user->setFirstName("Participant");
		$user->setLastName("Test" . rand(1, 100));
		$user->setSex(1);
		$user->setNationality('DNK');
		$user->setEmail('c.kaiser.p' . rand(20, 2000) . '@tester.dk');
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

		return;

	}
}
