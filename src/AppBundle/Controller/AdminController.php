<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
	/**
	 * @Route("/", name="admin_home")
	 */
    public function indexAction()
    {
        return $this->render('admin/home.html.twig', array());
    }
}
