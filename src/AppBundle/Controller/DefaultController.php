<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/User/profile", name="user_profile")
     * @Template("AppBundle:Default:profile.html.twig")
     */
    public function profileAction()
    {
        return array();
    }
}
