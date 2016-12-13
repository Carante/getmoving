<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Identity;
use AppBundle\Entity\Media;
use AppBundle\Entity\Organisation;
use AppBundle\Entity\Program;
use AppBundle\Entity\ProgramParticipants;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseController extends Controller
{
	/**
	 * @return \Doctrine\Common\Persistence\ObjectManager|object
	 */
	protected function getEntityManager()
	{
		$em = $this->getDoctrine()->getManager();

		return $em;
	}

	protected function viewVariables($pageName)
	{
		$viewVar['pageTitle'] = $pageName . "|GetMoving";


		$profiles = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
		$viewVar['profiles'] = $profiles;
		$profilesCount = count($profiles) - 1;

		$volunteers = [];
		$users = [];
		for ($i = 0 ; $i <= $profilesCount ; ++$i) {
			if (in_array('ROLE_ADMIN', $profiles[$i]->getRoles(), true)){
				$users[] = $profiles[$i];
			} elseif (in_array('ROLE_VOLUNTEER', $profiles[$i]->getRoles(), true)) {
				$volunteers[] = $profiles[$i];
			}
		}
		$viewVar['volunteers'] = $volunteers;
		$viewVar['users'] = $users;

		$programs = $this->getDoctrine()->getRepository('AppBundle:Program')->findAll();
		$viewVar['programs'] = $programs;

		$participants = $this->getDoctrine()->getRepository('AppBundle:ProgramParticipants')->findAll();
		$viewVar['participants'] = $participants;

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		$orgName = "Dummy";
		$logo = new Media();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];

			$orgName = $currentOrg->getName();
		} else {
			$currentOrg = new Organisation();
		}
		$viewVar['organisation'] = $currentOrg;
		$viewVar['orgName'] = $orgName;

		$media = $this->getDoctrine()->getRepository('AppBundle:Media')->findAll();
		$media == null ? $medias = [] : $medias = $media;
		$viewVar['medias'] = $medias;

		return $viewVar;
	}

	protected function viewVariablesPublic($pageName)
	{
		$viewVar['pageTitle'] = "GetMoving - ".$pageName;

		$programs = $this->getDoctrine()->getRepository('AppBundle:Program')->findBy(array(
			'isActive' => true
		));
		$viewVar['programs'] = $programs;

		$profiles = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
		$viewVar['profiles'] = $profiles;

		$participants = $this->getDoctrine()->getRepository('AppBundle:ProgramParticipants')->findAll();
		$viewVar['participants'] = $participants;

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];

			if ($currentOrg->getLogo() != null) {
				$logo = $this->getDoctrine()->getRepository('AppBundle:Media')->find($currentOrg->getLogo());
				$logo = $logo->getPath() . $logo->getFileName();
			}	else {
				$logo = "media/dummy.png";
			}

		} else {
			$logo = "media/dummy.png";
			$currentOrg = new Organisation();
		}
		$viewVar['organisation'] = $currentOrg;
		$viewVar['logo'] = DIRECTORY_SEPARATOR.$logo;

		return $viewVar;
	}

	protected function sendEmailContact($data){
		$currentOrg = new Organisation();

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];
		}

		$GMmail = 'c.kaiser.p';
		$GMmailPassword = 'paustian';

		$name = $currentOrg->getName();
		$emailTo = $currentOrg->getEmailSupport();

		// http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
		$transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465 or 535,'ssl')
			->setUsername($GMmail)
			->setPassword($GMmailPassword);

		$mailer = \Swift_Mailer::newInstance($transport);
		$message = \Swift_Message::newInstance($data['subject'])
			->setFrom(array($data['email'] => $data['name']))
			->setTo(array($emailTo => $name." Support"))
			->setReplyTo(array($data['email'] => $data['name']))
			->setBody($data['message'], 'text/html');

		return $mailer->send($message);
	}

	protected function sendEmailUserAdded(User $user, $password = ""){
		$currentOrg = new Organisation();

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];
		}

		$GMmail = 'c.kaiser.p@gmail.com';
		$GMmailPassword = 'paustian';

		$name = $currentOrg->getName();
		$systemEmail = $currentOrg->getEmailOfficial();
		$supportEmail = $currentOrg->getEmailSupport();
		$noReplyEmail = "noreply@".$name.".com";

		$firstName = $user->getFirstName();
		$lastName = $user->getLastName();
		$middleName = $user->getMiddleName();

		$fullName = "";
		!empty($middleName) ? $fullName = $firstName." ".$middleName." ".$lastName : $fullName = $firstName." ".$lastName;

		$userEmail = $user->getEmail();


		// http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
		$transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
			->setUsername($GMmail)
			->setPassword($GMmailPassword);


		$body = "
					<h2>Welcome to ".$name."</h2>
					<h4>Herer are your login information</h4>
					<p><strong>Email: </strong>".$userEmail."</p>
					<p><strong>Password: </strong>".$password."</p>
					For any questions please contact us on: ".$supportEmail
		;

		$mailer = \Swift_Mailer::newInstance($transport);
		$message = \Swift_Message::newInstance($name." | Welcome")
			->setFrom(array($noReplyEmail => "NoReply | ".$name))
			->setTo(array($userEmail => $fullName))
			->setReplyTo(array($noReplyEmail => "NoReply"))
			->setBody($body, 'text/html');

		return $mailer->send($message);
	}
	protected function sendEmailSystemUserAdded(User $user){
		$currentOrg = new Organisation();

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];
		}

		$GMmail = 'c.kaiser.p@gmail.com';
		$GMmailPassword = 'paustian';

		$name = $currentOrg->getName();
		$systemEmail = $currentOrg->getEmailOfficial();
		$supportEmail = $currentOrg->getEmailSupport();

		$firstName = $user->getFirstName();
		$lastName = $user->getLastName();
		$middleName = $user->getMiddleName();

		$fullName = "";
		!empty($middleName) ? $fullName = $firstName." ".$middleName." ".$lastName : $fullName = $firstName." ".$lastName;

		$sex = "";
		$user->getSex() == 1 ? $sex = "Male" : $sex = "Female" ;

		// http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
		$transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
			->setUsername($GMmail)
			->setPassword($GMmailPassword);

		$body = "
			<h2>New user has been registered</h2>
			<h4>The following data has been added</h4>
			<p><strong>Name: </strong>".$fullName."</p>
			<p><strong>Email: </strong>".$user->getEmail()."</p>
			<p><strong>Phone: </strong>".$user->getPhone()."</p>
			<p><strong>Nationality: </strong>".$user->getPhone()."</p>
			<p><strong>Birthdate: </strong>".$user->getDateOfBirth()->format("d-M-Y")."</p>
			<p><strong>Gender: </strong>".$sex."</p>
			<p><strong>Country: </strong>".$user->getAddressCountry()."</p>
			<p><strong>Region: </strong>".$user->getAddressRegion()."</p>
			<p><strong>City, zip: </strong>".$user->getAddressCity().", ".$user->getAddressZip()."</p>
			<p><strong>Street: </strong>".$user->getAddressStreet()."</p>
			<p><strong>House No.: </strong>".$user->getAddressHouseNo()."</p>
			<p><strong>Suite, flat, PoBox etc.: </strong>".$user->getAddressPoBox()."</p>
			<p><strong>C/O : </strong>".$user->getAddressCo()."</p>
		";

		$mailer = \Swift_Mailer::newInstance($transport);
		$message = \Swift_Message::newInstance("New user added | ".$name)
			->setFrom(array($systemEmail => $name))
			->setTo(array($systemEmail => $name))
			->setReplyTo(array($user->getEmail() => $fullName))
			->setBody($body, 'text/html');

		return $mailer->send($message);
	}



	protected function sendEmailUserParticipation(User $user, ProgramParticipants $participation){
		$currentOrg = new Organisation();

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];
		}

		$GMmail = 'c.kaiser.p@gmail.com';
		$GMmailPassword = 'paustian';

		$name = $currentOrg->getName();
		$systemEmail = $currentOrg->getEmailOfficial();
		$supportEmail = $currentOrg->getEmailSupport();

		$firstName = $user->getFirstName();
		$lastName = $user->getLastName();
		$middleName = $user->getMiddleName();

		!empty($middleName) ? $fullName = $firstName." ".$middleName." ".$lastName : $fullName = $firstName." ".$lastName;

		$userEmail = $user->getEmail();


		// http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
		$transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
			->setUsername($GMmail)
			->setPassword($GMmailPassword);

		$program = $participation->getProgram();
		$body = "
			<h2>You have planned to volunteer!</h2>
			<h4>".$program->getTitle()."</h4>
			<p>You have successfully signe up for participating in the program ".$program->getTitle()."</p>
			<p>Your participation will start ".$participation->getArrivalDate()->format("d-M-Y")." and it will last for ".$participation->getDuration()." weeks.</p>
			For any questions please contact us on: ".$supportEmail
		;


		$mailer = \Swift_Mailer::newInstance($transport);
		$message = \Swift_Message::newInstance($name." | Welcome")
			->setFrom(array($supportEmail => "NoReply | ".$name))
			->setTo(array($userEmail => $fullName))
			->setReplyTo(array($supportEmail => "NoReply"))
			->setBody($body, 'text/html');

		return $mailer->send($message);
	}
	protected function sendEmailSystemUserParticipation(User $user, ProgramParticipants $participation){
		$currentOrg = new Organisation();

		$organisations = $this->getDoctrine()->getRepository('AppBundle:Organisation')->findAll();
		if (!empty($organisations)) {
			$count = count($organisations)-1;
			$currentOrg = $organisations[$count];
		}

		$GMmail = 'c.kaiser.p@gmail.com';
		$GMmailPassword = 'paustian';

		$name = $currentOrg->getName();
		$systemEmail = $currentOrg->getEmailOfficial();
		$supportEmail = $currentOrg->getEmailSupport();

		$firstName = $user->getFirstName();
		$lastName = $user->getLastName();
		$middleName = $user->getMiddleName();

		$fullName = "";
		!empty($middleName) ? $fullName = $firstName." ".$middleName." ".$lastName : $fullName = $firstName." ".$lastName;

		$sex = "";
		$user->getSex() == 1 ? $sex = "Male" : $sex = "Female" ;

		// http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
		$transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
			->setUsername($GMmail)
			->setPassword($GMmailPassword);

		$program = $participation->getProgram();

		$body = "
			<h2>".$fullName." will participate in ".$program->getTitle()."</h2>
			<h4>The following information is given</h4>
			<p><strong>Participators Name: </strong>".$fullName."</p>
			<p><strong>Participators Email: </strong>".$user->getEmail()."</p>
			<p><strong>Participators Phone: </strong>".$user->getPhone()."</p>
			<p><strong>Arrival date: </strong>".$participation->getArrivalDate()->format("d-M-Y")."</p>
			<p><strong>Duration: </strong>".$participation->getDuration()." weeks</p>
			<p><strong>Role: </strong>".$program->getRole()."</p>
			<p><strong>Location: </strong>".$program->getLocation()."</p>
			<p><strong>Stay: </strong>".$program->getStay()."</p>
			<p><strong>Meals: </strong>".$program->getMeals()."</p>
		";

		$mailer = \Swift_Mailer::newInstance($transport);
		$message = \Swift_Message::newInstance("New participation in program | ".$name)
			->setFrom(array($systemEmail => $name))
			->setTo(array($systemEmail => $name))
			->setReplyTo(array($user->getEmail() => $fullName))
			->setBody($body, 'text/html');

		return $mailer->send($message);
	}

	protected function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
						$output = array(
							"city"           => @$ipdat->geoplugin_city,
							"state"          => @$ipdat->geoplugin_regionName,
							"country"        => @$ipdat->geoplugin_countryName,
							"country_code"   => @$ipdat->geoplugin_countryCode,
							"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode
						);
						break;
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
				}
			}
		}
		return $output;
	}

}
