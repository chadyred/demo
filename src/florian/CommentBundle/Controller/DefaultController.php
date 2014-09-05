<?php

namespace florian\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('florianCommentBundle:Default:index.html.twig', array('name' => $name));
    }
}
