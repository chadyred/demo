<?php

namespace florian\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('florianUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
