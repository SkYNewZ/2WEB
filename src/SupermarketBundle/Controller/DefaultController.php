<?php

namespace SupermarketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	return $this->render('SupermarketBundle:Default:index.html.twig');
    }

	public function contactAction()
	{
		return $this->render('SupermarketBundle:Default:contact.html.twig');
	}

	public function checkoutAction()
	{
		return $this->render('SupermarketBundle:Default:checkout.html.twig');
	}
}
